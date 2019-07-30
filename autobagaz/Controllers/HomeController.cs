using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using autobagaz.Models;

namespace autobagaz.Controllers
{
    public class HomeController : Controller
    {
        private readonly AutobagazContext context;

        //public List<User> Users { get; set; }
        public HomeController(AutobagazContext db)
        {
            context = db;
        }


        public ActionResult Index()
        {
            //Users = context.Users.ToList();

            //return View(Users);
            return View();
        }

        public IActionResult Privacy()
        {
            return View();
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
