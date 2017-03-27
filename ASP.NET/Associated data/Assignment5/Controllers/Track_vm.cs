using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;
using System.Web.Mvc;

namespace Assignment5.Controllers
{
    public class TrackAdd
    {

        [Required, Range(1, 100)]
        [Display(Name = "Track name")]
        public string Name { get; set; }
        [Required, Range(1, 100)]
        [Display(Name = "Composer")]
        public string Composer { get; set; }
        [Required, Range(3, 100)]
        [Display(Name = "Length (ms)")]
        public int Milliseconds { get; set; }
        [Required, Range(0, Int32.MaxValue)]
        [Display(Name = "Unit price")]
        public decimal UnitPrice { get; set; }
        [Required]
        public int AlbumId { get; set; }
        [Required]
        public int MediaTypeId { get; set; }

    }

    public class TrackBase : TrackAdd
    {
        public TrackBase()
        {
            Milliseconds = 0;
            UnitPrice = 0;
        }
        [Key]
        public int TrackId { get; set; }
    }

    public class TrackWithDetail : TrackBase
    {

        [Display(Name = "Artist name")]
        public string AlbumArtistName { get; set; }
        [Display(Name = "Album title")]
        public string AlbumTitle { get; set; }
        [Display(Name = "Media type")]
        public string MediaTypeName { get; set; }

    }

    public class TrackAddForm : TrackAdd
    {
 
        [Required]
        [Display(Name = "Album")]
        public SelectList AlbumList { get; set; }
        [Required]
        [Display(Name = "Media Type")]
        public SelectList MediaTypeList { get; set; }


    }

}