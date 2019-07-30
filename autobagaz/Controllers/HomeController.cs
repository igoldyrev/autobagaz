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

        public List<User> Users { get; set; }
        public HomeController(AutobagazContext db)
        {
            context = db;
        }


        public ActionResult Index()
        {
            Users = context.Users.ToList();

            //using (var context = new AutobagazContext())
            //{
            //    return View(context.Users);
            //}
            //{

            //    List<User> _TList = new List<User>();

            //    int pageSize = 10; // количество объектов на страницу
            //    IEnumerable<User> materialPerPages = Users.Skip((page - 1) * pageSize).Take(pageSize);
            //    PageInfo pageInfo = new PageInfo { PageNumber = page, PageSize = pageSize, TotalItems = Users.Count };
            //    IndexViewModel ivm = new IndexViewModel { PageInfo = pageInfo, User = materialPerPages };

            return View(Users);
            //}


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
