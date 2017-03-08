using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
// new...
using AutoMapper;
using Assignment5.Models;

namespace Assignment5.Controllers
{
    public class Manager
    {
        // Reference to the data context
        private DataContext ds = new DataContext();

        public Manager()
        {
            // If necessary, add constructor code here
        }

        // Add methods below
        // Controllers will call these methods
        // Ensure that the methods accept and deliver ONLY view model objects and collections
        // The collection return type is almost always IEnumerable<T>

        // Suggested naming convention: Entity + task/action
        // For example:
        // AlbumGetAll
        // (optional) ArtistGetAll
        // MediaTypeGetAll
        // TrackGetAll (or TrackGetAllWithDetail)
        // AlbumGetById
        // MediaTypeGetById
        // ********************
        // TrackAdd

        public IEnumerable<AlbumBase> AlbumGetAll()
        {
            return Mapper.Map<IEnumerable<Album>, IEnumerable<AlbumBase>>(ds.Albums.OrderBy(c => c.Title));
        }

        public IEnumerable<ArtistBase> ArtistGetAll()
        {
            return Mapper.Map<IEnumerable<Artist>, IEnumerable<ArtistBase>>(ds.Artists.OrderBy(c => c.Name));
        }

        public IEnumerable<MediaTypeBase> MediaTypeGetAll()
        {
            return Mapper.Map<IEnumerable<MediaType>, IEnumerable<MediaTypeBase>>(ds.MediaTypes.OrderBy(c => c.Name));
        }

        public IEnumerable<TrackWithDetail> TrackGetAllWithDetail()
        {
            var c = ds.Tracks.Include("Album");

            return Mapper.Map<IEnumerable<Track>, IEnumerable<TrackWithDetail>>(c.OrderBy(m => m.Name));
        }

        // GetByIds

        public AlbumBase AlbumGetById(int id)
        {
            // Attempt to fetch the object
            var o = ds.Albums.Find(id);

            // Return the result, or null if not found
            return (o == null) ? null : Mapper.Map<Album, AlbumBase>(o);
        }

        public MediaTypeBase MediaTypeGetById(int id)
        {
            // Attempt to fetch the object
            var o = ds.MediaTypes.Find(id);

            // Return the result, or null if not found
            return (o == null) ? null : Mapper.Map<MediaType, MediaTypeBase>(o);
        }

        public TrackBase TrackGetById(int id)
        {
            var o = ds.Tracks.Include("Album")
                .SingleOrDefault(v => v.TrackId == id);

            // Return the result, or null if not found
            return (o == null) ? null : Mapper.Map<Track, TrackWithDetail>(o);
        }

        // Add

        public TrackWithDetail TrackAdd(TrackAdd newItem)
        {
            var a = ds.Albums.Find(newItem.AlbumId);
            var b = ds.MediaTypes.Find(newItem.MediaTypeId);

            if (a == null || b == null)
            {
                return null;
            }
            else
            {

                var addedItem = ds.Tracks.Add(Mapper.Map<TrackAdd, Track>(newItem));
                // Set the associated item property
                addedItem.Album = a;
                addedItem.MediaType = b;
                ds.SaveChanges();

                // If successful, return the added item, mapped to a view model object
                return (addedItem == null) ? null : Mapper.Map<Track, TrackWithDetail>(addedItem);

            }
        }

    }
}