using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;

namespace Assignment5.Controllers
{
    public class MediaTypeBase
    {

        [Key]
        public int MediaTypeId { get; set; }
        public string Name { get; set; }

    }
}