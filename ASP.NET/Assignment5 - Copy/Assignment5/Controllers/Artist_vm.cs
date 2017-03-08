using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;

namespace Assignment5.Controllers
{
    public class ArtistBase
    {

        [Key]
        public int ArtistId { get; set; }
        public string Name { get; set; }

    }
}