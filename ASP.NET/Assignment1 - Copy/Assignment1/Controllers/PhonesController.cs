using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace Assignment1.Controllers
{
    public class PhonesController : Controller
    {

        //Collection of Phones
        private List<PhoneBase> Phones;

        public PhonesController()
        {
            //Initialize the collection
            Phones = new List<PhoneBase>();

            //Add to the collection, using original syntax
            var iPhone = new PhoneBase();
            iPhone.Id = 1;
            iPhone.PhoneName = "iPhone 8";
            iPhone.Manufacturer = "Apple";
            iPhone.DateReleased = new DateTime(2017, 9, 1);
            iPhone.MSRP = 849;
            iPhone.ScreenSize = 5.5;
            Phones.Add(iPhone);

            // Add using the newer object initializer syntax
            var galaxy = new PhoneBase
            {
                Id = 2,
                PhoneName = "Galaxy Note 8",
                Manufacturer = "Samsung",
                DateReleased = new DateTime(2017, 8, 1),
                MSRP = 749,
                ScreenSize = 5.7
            };
            Phones.Add(galaxy);

            //Add to the collection, using object initializer syntax,
            // directly as the argument to the Phones.Add() method
            Phones.Add(new PhoneBase
            {
                Id = 3,
                PhoneName = "Surface Phone",
                Manufacturer = "Microsoft",
                DateReleased = new DateTime(2017, 3, 1),
                MSRP = 800,
                ScreenSize = 5.5

            });

        }
        // GET: Phones
        public ActionResult Index()
        {
            return View(Phones);
        }

        // GET: Phones/Details/5
        public ActionResult Details(int id)
        {
            return View(Phones[id - 1]);
        }

        // GET: Phones/Create
        
        public ActionResult Create()
        {
            return View();
        }

        // POST: Phones/Create
        [HttpPost]
        public ActionResult Create(FormCollection collection)
        {
            try
            {
                var newItem = new PhoneBase();

                //configure the unique identifier
                newItem.Id = Phones.Count + 1;

                newItem.PhoneName = collection["PhoneName"];
                newItem.Manufacturer = collection["Manufacturer"];

                newItem.DateReleased = Convert.ToDateTime(collection["DateReleased"]);

                int msrp;
                double ss;
                bool isNumber;

                isNumber = Int32.TryParse(collection["MSRP"], out msrp);
                newItem.MSRP = msrp;

                isNumber = double.TryParse(collection["ScreenSize"], out ss);
                newItem.ScreenSize = ss;
                Phones.Add(newItem);

                return View("Details", newItem);

               // return RedirectToAction("Index");

            }
            catch
            {
                return View();
            }
        }

        // GET: Phones/Edit/5
        /*
        public ActionResult Edit(int id)
        {
            return View();
        }

        // POST: Phones/Edit/5
        [HttpPost]
        public ActionResult Edit(int id, FormCollection collection)
        {
            try
            {
                // TODO: Add update logic here

                return RedirectToAction("Index");
            }
            catch
            {
                return View();
            }
        }

        // GET: Phones/Delete/5
        public ActionResult Delete(int id)
        {
            return View();
        }

        // POST: Phones/Delete/5
        [HttpPost]
        public ActionResult Delete(int id, FormCollection collection)
        {
            try
            {
                // TODO: Add delete logic here

                return RedirectToAction("Index");
            }
            catch
            {
                return View();
            }
        }
        */
    }
}
