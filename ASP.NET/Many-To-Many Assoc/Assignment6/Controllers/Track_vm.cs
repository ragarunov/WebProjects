using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;

namespace Assignment6.Controllers
{
    public class TrackBase
    {
        [Key]
        public int TrackId { get; set; }
        public string Name { get; set; }
        public int Milliseconds { get; set; }
        public string Composer { get; set; }
        public decimal UnitPrice { get; set; }
        public string FullName
        {
            get
            {
                var ms = Math.Round((((double)Milliseconds / 1000) / 60), 1);
                var composer = string.IsNullOrEmpty(Composer) ? "" : ", composer " + Composer;
                var trackLength = (ms > 0) ? ", " + ms.ToString() + " minutes" : "";
                var unitPrice = (UnitPrice > 0) ? ", $ " + UnitPrice.ToString() : "";

                return string.Format("{0}{1}{2}{3}", Name, composer, trackLength, unitPrice);

            }
        }
    }
}