using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;

namespace Assignment5.Controllers
{
    public class AlbumBase
    {
        [Key]
        public int AlbumId { get; set; }
        public string Title { get; set; }

    }
}