using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using System;
using System.Linq;
using System.Security.Claims;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;

namespace autobagaz
{
    public class AccountController : Controller
    {
        private readonly AutobagazContext context;

        public AccountController(AutobagazContext db)
        {
            context = db;
        }

        [HttpGet]
        public IActionResult Login()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Login(LoginViewModel ViewModel)
        {
            if (ModelState.IsValid)
            {
                string loginFormToLower = ViewModel.USERNAME.ToLower();
                string loginFormToUpper = ViewModel.USERNAME.ToUpper();
                string userstring = loginFormToLower + ViewModel.PASSWORD;
                userstring = GetHash(userstring);
                string loginDbToUpper = context.AUTOBAGAZ_USER.Where(
                    u => u.AUTOBAGAZ_USER_NAME == ViewModel.USERNAME)
                    .Select(u => u.AUTOBAGAZ_USER_NAME)
                    .SingleOrDefault().ToUpper();
                AUTOBAGAZ_USER user = await context.AUTOBAGAZ_USER
                    .Include(u => u.AUTOBAGAZ_ROLE)
                    .Include(u => u.AUTOBAGAZ_STATUS)
                    .FirstOrDefaultAsync(u => u.AUTOBAGAZ_USER_NAME.ToUpper() == loginFormToUpper
                    && u.AUTOBAGAZ_USER_PASSWORD == userstring && u.AUTOBAGAZ_USER_IS_ACTIVE == true && u.AUTOBAGAZ_USER_STATUS_ID != 4);

                if (user != null)
                {
                    ClaimsIdentity claim = new ClaimsIdentity("ApplicationCookie", ClaimsIdentity.DefaultNameClaimType, ClaimsIdentity.DefaultRoleClaimType);
                    claim.AddClaim(new Claim(ClaimTypes.NameIdentifier, user.AUTOBAGAZ_USER_ID.ToString(), ClaimValueTypes.String));
                    claim.AddClaim(new Claim(ClaimTypes.NameIdentifier, user.AUTOBAGAZ_USER_NAME, ClaimValueTypes.String));
                    claim.AddClaim(new Claim("http://schemas.microsoft.com/accesscontrolservice/2010/07/claims/identityprovider",
                        "OWIN Provider", ClaimValueTypes.String));
                    if (user.AUTOBAGAZ_ROLE != null)
                        claim.AddClaim(new Claim(ClaimsIdentity.DefaultRoleClaimType, user.AUTOBAGAZ_ROLE.AUTOBAGAZ_ROLE_NAME, ClaimValueTypes.String));

                    await HttpContext.SignInAsync(CookieAuthenticationDefaults.AuthenticationScheme, new ClaimsPrincipal(claim));

                    return RedirectToAction("Index", "Home");
                }
                else
                {
                    ModelState.AddModelError("", "Некорректные логин и(или) пароль");
                }
            }
            return View(ViewModel);
        }

        public async Task<IActionResult> Logout()
        {
            await HttpContext.SignOutAsync(CookieAuthenticationDefaults.AuthenticationScheme);
            return RedirectToAction("Login", "Account");
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