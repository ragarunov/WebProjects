    const WebSocket = require('ws');
    const connect = require('connect');
    const serveStatic = require('serve-static');
    const low = require('lowdb');
    const FileSync = require('lowdb/adapters/FileSync');
     
    const adapter = new FileSync('db.json');
    let db = low(adapter);
     
    let http_port = 8000;
    let ws_port = 8001;
    if (process.env.DEVELOP) {
        http_port = 8002;
        ws_port = 8003;
        const adapter = new FileSync('db_dev.json');
        db = low(adapter);
    }
     
    connect().use(serveStatic('static')).listen(http_port, function(){
        console.log('Server running on '+http_port+'...');
    });
     
    const wss = new WebSocket.Server({ port: ws_port});
     
    db.defaults({ msgs: [], count: 0 })
      .write();
     
    function validateData(data, ip) {
        let latest = db.get('msgs').filter({user_id : ip}).sortBy('time').reverse().take(1).value();
     
        if (latest.length == 1)
            latest = latest[0];
        
        if (latest && ((new Date()).getTime() - latest.time) < 3000)
            return null;
        
        try {
            data = JSON.parse(data);
        } catch(e) {
            return null;
        }
     
        if (data.topic != "@tg")
            return null;
        
     
        let valid_data = {};
        if (!data.text)
            return null;
        
        let user_name = data.user_name ? data.user_name.slice(0,100) : "User";
        valid_data.user_name = user_name;
        valid_data.text = data.text.slice(0, 155);
        valid_data.time = (new Date()).getTime();
        db.update('count', n => n + 1).write();
        valid_data.msg_id = db.get('count').value();
        valid_data.user_id = ip;
     
        db.get('msgs').push(valid_data).write();
        return JSON.stringify(valid_data);
    }
     
    function broadcast(msg) {
        wss.clients.forEach(function each(client) {
          if (client.readyState === WebSocket.OPEN) {
            client.send(msg);
          }
        });
    }
     
    function sendLatest(ws, num, ip) {
      let handshake = {
        handshake: 1,
        user_id: ip
      };
      ws.send(JSON.stringify(handshake));
      let msgs = db.get('msgs').sortBy('time').reverse().take(num).sortBy('time').value();
      for (let msg of msgs)
        ws.send(JSON.stringify(msg));
    }
     
    wss.on('connection', function connection(ws, req) {
      let ip = req.headers['x-forwarded-for'] || req.connection.remoteAddress || ws._socket.remoteAddress;
     
      sendLatest(ws, 100, ip);
      ws.on('message', function incoming(data) {
        let validated_data = validateData(data, ip);
        if (validated_data) {
            broadcast(validated_data);
        }
      });
    });