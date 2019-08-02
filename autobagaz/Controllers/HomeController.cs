using System;
using System.Diagnostics;
using System.Linq;
using Microsoft.AspNetCore.Mvc;
using autobagaz.Models;
using System.Security.Cryptography;
using System.Text;

namespace autobagaz.Controllers
{
    public class HomeController : Controller
    {
        private readonly AutobagazContext context;

        //public List<User> Users { get; set; }
        public HomeController(AutobagazContext db)
        {
            context = db;

            if (!context.AUTOBAGAZ_STATUS.Any())
            {
                context.AUTOBAGAZ_STATUS.Add(new AUTOBAGAZ_STATUS
                {
                    AUTOBAGAZ_STATUS_ID = 1,
                    AUTOBAGAZ_STATUS_CODE = "CREATE",
                    AUTOBAGAZ_STATUS_NAME = "СОЗДАН"
                });
                context.AUTOBAGAZ_STATUS.Add(new AUTOBAGAZ_STATUS
                {
                    AUTOBAGAZ_STATUS_ID = 2,
                    AUTOBAGAZ_STATUS_CODE = "CHANGED",
                    AUTOBAGAZ_STATUS_NAME = "ИЗМЕНЕН"
                });
                context.AUTOBAGAZ_STATUS.Add(new AUTOBAGAZ_STATUS
                {
                    AUTOBAGAZ_STATUS_ID = 3,
                    AUTOBAGAZ_STATUS_CODE = "DELETE",
                    AUTOBAGAZ_STATUS_NAME = "УДАЛЕН"
                });
                context.AUTOBAGAZ_STATUS.Add(new AUTOBAGAZ_STATUS
                {
                    AUTOBAGAZ_STATUS_ID = 4,
                    AUTOBAGAZ_STATUS_CODE = "BLOCKED",
                    AUTOBAGAZ_STATUS_NAME = "БЛОКИРОВАН"
                });
                context.SaveChanges();
            }

            if (!context.AUTOBAGAZ_ROLE.Any())
            {
                context.AUTOBAGAZ_ROLE.Add(new AUTOBAGAZ_ROLE
                {
                    AUTOBAGAZ_ROLE_ID = 1,
                    AUTOBAGAZ_ROLE_NAME = "Администратор",
                    AUTOBAGAZ_ROLE_DESCRIPTION = "Администратор системы"
                });
                context.AUTOBAGAZ_ROLE.Add(new AUTOBAGAZ_ROLE
                {
                    AUTOBAGAZ_ROLE_ID = 2,
                    AUTOBAGAZ_ROLE_NAME = "Пользователь",
                    AUTOBAGAZ_ROLE_DESCRIPTION = "Пользователь системы"
                });
                context.SaveChanges();
            }

            if (!context.AUTOBAGAZ_USER.Any())
            {
                context.AUTOBAGAZ_USER.Add(new AUTOBAGAZ_USER
                {
                    AUTOBAGAZ_USER_ID = 1,
                    AUTOBAGAZ_USER_NAME = "admin",
                    AUTOBAGAZ_USER_EMAIL = "autobagaz@yandex.ru",
                    AUTOBAGAZ_USER_PASSWORD = GetHash("adminautobagaz"),
                    AUTOBAGAZ_USER_IS_ACTIVE = true,
                    AUTOBAGAZ_USER_ROLE_ID = 1,
                    AUTOBAGAZ_USER_DATE = DateTime.Now.ToString("d") + " " + DateTime.Now.ToString("t"),
                    AUTOBAGAZ_USER_STATUS_ID = 1
                });
                context.SaveChanges();
            }
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

        #region AdditionalFunctions

        public static string GetHash(string input)
        {
            var md5 = MD5.Create();
            var hash = md5.ComputeHash(Encoding.UTF8.GetBytes(input));
            return Convert.ToBase64String(hash);
        }

        #endregion
    }
}
