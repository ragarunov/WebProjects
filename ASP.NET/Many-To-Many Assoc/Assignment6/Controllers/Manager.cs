using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
// new...
using AutoMapper;
using Assignment6.Models;

namespace Assignment6.Controllers
{
    public class Manager
    {
        // Reference to the data context
        private DataContext ds = new DataContext();

        public Manager()
        {
            // Turn off the Entity Framework (EF) proxy creation features
            // We do NOT want the EF to track changes - we'll do that ourselves
            ds.Configuration.ProxyCreationEnabled = false;

            // Also, turn off lazy loading...
            // We want to retain control over fetching related objects
            ds.Configuration.LazyLoadingEnabled = false;
        }

        public IEnumerable<PlaylistBase> PlaylistGetAll()
        {
            return Mapper.Map<IEnumerable<Playlist>, IEnumerable<PlaylistBase>>(ds.Playlists.Include("Tracks").OrderBy(e => e.Name));
        }

        public IEnumerable<TrackBase> TrackGetAll()
        {
            return Mapper.Map<IEnumerable<Track>, IEnumerable<TrackBase>>(ds.Tracks.OrderBy(e => e.Name));
        }

        public PlaylistWithDetail PlaylistGetByIdWithDetail(int id)
        {
            // Attempt to fetch the object
            var o = ds.Playlists.Include("Tracks").OrderBy(e => e.Name).SingleOrDefault(e => e.PlaylistId == id);

            // Return the result, or null if not found
            return (o == null) ? null : Mapper.Map<Playlist, PlaylistWithDetail>(o);
        }

        public PlaylistWithDetail PlaylistEditTracks(PlaylistEditTracks newItem)
        {
            // Attempt to fetch the object
            var o = ds.Playlists.Include("Tracks").SingleOrDefault(e => e.PlaylistId == newItem.PlaylistId);

            if (o == null)
            {
                // Problem - object was not found, so return
                return null;
            }
            else
            {
                // Update the object with the incoming values

                // First, clear out the existing collection
                o.Tracks.Clear();

                // Then, go through the incoming items
                // For each one, add to the fetched object's collection
                foreach (var item in newItem.TracksIds)
                {
                    var a = ds.Tracks.Find(item);
                    o.Tracks.Add(a);
                }
                // Save changes
                ds.SaveChanges();

                return Mapper.Map<Playlist, PlaylistWithDetail>(o);
            }
        }
    }
}