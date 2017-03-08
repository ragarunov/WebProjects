using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using AutoMapper;

namespace Assignment6.Controllers
{
    public class PlaylistController : Controller
    {
        // GET: Playlist
        private Manager m = new Manager();

        public ActionResult Index()
        {
            return View(m.PlaylistGetAll());
        }

        // GET: Playlist/Details/5
        public ActionResult Details(int? id)
        {
            // Attempt to get the matching object
            var o = m.PlaylistGetByIdWithDetail(id.GetValueOrDefault());

            if (o == null)
            {
                return HttpNotFound();
            }
            else
            {
                // Pass the object to the view
                return View(o);
            }

        }


        // GET: Playlist/Edit/5
        public ActionResult Edit(int? id)
        {
            // Attempt to fetch the matching object
            var o = m.PlaylistGetByIdWithDetail(id.GetValueOrDefault());

            if (o == null)
            {
                return HttpNotFound();
            }
            else
            {
                // Create a form, based on the fetched matching object
                var form = Mapper.Map<PlaylistBase, PlaylistEditTracksForm>(o);

                // For the multi select list, configure the "selected" items
                var selectedValues = o.Tracks.Select(jd => jd.TrackId);

                form.TracksPlaying = o.Tracks.OrderBy(e => e.Name);

                form.TracksList = new MultiSelectList
                    (items: m.TrackGetAll(),
                    dataValueField: "TrackId",
                    dataTextField: "FullName",
                    selectedValues: selectedValues);

                return View(form);
            }

        }

        // POST: Playlist/Edit/5
        // Handle the data submitted by the browser user
        [HttpPost]
        public ActionResult Edit(int? id, PlaylistEditTracks newItem)
        {
            // Validate the input
            if (!ModelState.IsValid)
            {
                return RedirectToAction("edit", new { id = newItem.PlaylistId });
            }

            if (id.GetValueOrDefault() != newItem.PlaylistId)
            {
                return RedirectToAction("index");
            }

            // Attempt to do the update
            var editedItem = m.PlaylistEditTracks(newItem);

            if (editedItem == null)
            {
                return RedirectToAction("Index", new { id = newItem.PlaylistId });
            }
            else
            {
                // Show the details view, which will have the updated data
                return RedirectToAction("Details", new { id = newItem.PlaylistId });
            }
        }

    }
}
