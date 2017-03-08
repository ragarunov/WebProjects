using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
// new...
using AutoMapper;

namespace Assignment6
{
    public static class AutoMapperConfig
    {
        public static void RegisterMappings()
        {
            // AutoMapper create map statements - using AutoMapper static API
            // Mapper.Initialize(cfg => cfg.CreateMap< FROM , TO >());
            // Add map creation statements here

            Mapper.Initialize(cfg => {

                // Add map creation statements here
                cfg.CreateMap<Models.Playlist, Controllers.PlaylistBase>();
                cfg.CreateMap<Models.Playlist, Controllers.PlaylistWithDetail>();
                cfg.CreateMap<Controllers.PlaylistBase, Controllers.PlaylistEditTracksForm>();

                cfg.CreateMap<Models.Track, Controllers.TrackBase>();

            });


        }
    }
}