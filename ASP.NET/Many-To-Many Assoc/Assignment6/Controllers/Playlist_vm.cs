using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;
using System.Web.Mvc;

namespace Assignment6.Controllers
{
    public class PlaylistBase
    {

        [Key]
        public int PlaylistId { get; set; }
        [Display(Name = "Playlist name")]
        public string Name { get; set; }
        [Display(Name = "Number of tracks on this playlist")]
        public int TracksCount { get; set; }

    }

    public class PlaylistWithDetail : PlaylistBase
    {
        public PlaylistWithDetail()
        {
            Tracks = new List<TrackBase>();
        }

        public IEnumerable<TrackBase> Tracks { get; set; }

    }

    public class PlaylistEditTracksForm
    {
        [Key]
        public int PlaylistId { get; set; }
        public string Name { get; set; }
        public MultiSelectList TracksList { get; set; }
        public IEnumerable<TrackBase> TracksPlaying { get; set; }

    }

    public class PlaylistEditTracks
    {
        public PlaylistEditTracks()
        {
            TracksIds = new List<int>();
        }

        [Key]
        public int PlaylistId { get; set; }
        public IEnumerable<int> TracksIds { get; set; }
    }

}