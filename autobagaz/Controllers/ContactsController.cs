using System;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using Microsoft.AspNetCore.Authorization;

namespace autobagaz.Controllers
{
    public class ContactsController : Controller
    {
        private readonly AutobagazContext _context;

        public ContactsController(AutobagazContext context)
        {
            _context = context;
        }

        // GET: Contacts
        [AllowAnonymous]
        public async Task<IActionResult> Index(int page = 1)
        {
            int PageSize = 5; // количество объектов на страницу

            IQueryable<Shop> cities = _context.AUTOBAGAZ_SHOP
                .Include(s => s.City)
                .Where(s => s.AUTOBAGAZ_SHOP_STATUS_ID == 1 || s.AUTOBAGAZ_SHOP_STATUS_ID == 2);
            var count = cities.Count();
            var items = await cities.Skip((page - 1) * PageSize).Take(PageSize).ToListAsync();

            Pagination pagination = new Pagination(count, page, PageSize);
            PaginationViewModel pvm = new PaginationViewModel
            {
                Pagination = pagination,
                Shops = items
            };
            return View(pvm);
        }

        [Authorize(Roles = "admin")]
        public async Task<IActionResult> Archive(int page = 1)
        {
            int PageSize = 5; // количество объектов на страницу

            IQueryable<Shop> cities = _context.AUTOBAGAZ_SHOP
                .Include(s => s.City)
                .Where(s => s.AUTOBAGAZ_SHOP_STATUS_ID == 3);
            var count = cities.Count();
            var items = await cities.Skip((page - 1) * PageSize).Take(PageSize).ToListAsync();

            Pagination pagination = new Pagination(count, page, PageSize);
            PaginationViewModel pvm = new PaginationViewModel
            {
                Pagination = pagination,
                Shops = items
            };
            return View(pvm);
        }

        // GET: Contacts/AddShop
        [Authorize(Roles = "admin")]
        public IActionResult AddShop()
        {
            ViewData["AUTOBAGAZ_CITY_ID"] = new SelectList(_context.AUTOBAGAZ_CITY, "AUTOBAGAZ_CITY_ID", "AUTOBAGAZ_CITY_NAME");
            return View();
        }

        // POST: Contacts/Addshop
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> AddShop( Shop shop)
        {
            if (shop.AUTOBAGAZ_SHOP_NAME == null)
            {
                ModelState.AddModelError("", "Поле Название магазина является обязательным");
            }
            else if (shop.AUTOBAGAZ_SHOP_PHONE == null)
            {
                ModelState.AddModelError("", "Поле Телефон магазина является обязательным");
            }

            if (ModelState.IsValid)
            {
                if (shop.AUTOBAGAZ_SHOP_PHOTO_URL1 == null)
                {
                    shop.AUTOBAGAZ_SHOP_PHOTO_URL1 = "";
                }
                if (shop.AUTOBAGAZ_SHOP_PHOTO_URL2 == null)
                {
                    shop.AUTOBAGAZ_SHOP_PHOTO_URL2 = "";
                }
                if (shop.AUTOBAGAZ_SHOP_PHOTO_URL3 == null)
                {
                    shop.AUTOBAGAZ_SHOP_PHOTO_URL3 = "";
                }
                if (shop.AUTOBAGAZ_SHOP_PHOTO_URL4 == null)
                {
                    shop.AUTOBAGAZ_SHOP_PHOTO_URL4 = "";
                }
                ViewBag.SuccessAdd = true;
                shop.AUTOBAGAZ_SHOP_DATE = DateTime.Now.ToString("g");
                shop.AUTOBAGAZ_SHOP_STATUS_ID = 1;
                shop.AUTOBAGAZ_SHOP_USER_ID = User.Identity.GetUserId<int>();
                _context.Add(shop);
                await _context.SaveChangesAsync();
                return RedirectToAction(nameof(Index));
            }
            ViewData["AUTOBAGAZ_CITY_ID"] = new SelectList(_context.AUTOBAGAZ_CITY, "AUTOBAGAZ_CITY_ID", "AUTOBAGAZ_CITY_NAME", shop.AUTOBAGAZ_CITY_ID);
            return View(shop);
        }

        // GET: Contacts/Edit/5
        [Authorize(Roles = "admin")]
        public async Task<IActionResult> EditShop(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var shop = await _context.AUTOBAGAZ_SHOP.FindAsync(id);
            if (shop == null)
            {
                return NotFound();
            }
            ViewData["AUTOBAGAZ_CITY_ID"] = new SelectList(_context.AUTOBAGAZ_CITY, "AUTOBAGAZ_CITY_ID", "AUTOBAGAZ_CITY_NAME", shop.AUTOBAGAZ_CITY_ID);
            return View(shop);
        }

        // POST: Contacts/Edit/5
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> EditShop(int id, Shop shop)
        {
            if (id != shop.AUTOBAGAZ_SHOP_ID)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                    if (shop.AUTOBAGAZ_SHOP_PHOTO_URL1 == null)
                    {
                        shop.AUTOBAGAZ_SHOP_PHOTO_URL1 = "";
                    }
                    if (shop.AUTOBAGAZ_SHOP_PHOTO_URL2 == null)
                    {
                        shop.AUTOBAGAZ_SHOP_PHOTO_URL2 = "";
                    }
                    if (shop.AUTOBAGAZ_SHOP_PHOTO_URL3 == null)
                    {
                        shop.AUTOBAGAZ_SHOP_PHOTO_URL3 = "";
                    }
                    if (shop.AUTOBAGAZ_SHOP_PHOTO_URL4 == null)
                    {
                        shop.AUTOBAGAZ_SHOP_PHOTO_URL4 = "";
                    }

                    shop.AUTOBAGAZ_SHOP_DATE = DateTime.Now.ToString("g");
                    shop.AUTOBAGAZ_SHOP_STATUS_ID = 2;
                    shop.AUTOBAGAZ_SHOP_USER_ID = User.Identity.GetUserId<int>();
                    _context.Update(shop);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!ShopExists(shop.AUTOBAGAZ_SHOP_ID))
                    {
                        return NotFound();
                    }
                    else
                    {
                        throw;
                    }
                }
                return RedirectToAction(nameof(Index));
            }
            ViewData["AUTOBAGAZ_CITY_ID"] = new SelectList(_context.AUTOBAGAZ_CITY, "AUTOBAGAZ_CITY_ID", "AUTOBAGAZ_CITY_NAME", shop.AUTOBAGAZ_CITY_ID);
            return View(shop);
        }

        // GET: Contacts/Delete/5
        [Authorize(Roles = "admin")]
        public async Task<IActionResult> DeleteShop(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var shop = await _context.AUTOBAGAZ_SHOP.FindAsync(id);
            if (shop == null)
            {
                return NotFound();
            }

            return View(shop);
        }

        // POST: Contacts/Delete/5
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteShop( int id, Shop shop)
        {
            if (id != shop.AUTOBAGAZ_SHOP_ID)
            {
                return NotFound();
            }

            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL1 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL1 = "";
            }
            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL2 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL2 = "";
            }
            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL3 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL3 = "";
            }
            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL4 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL4 = "";
            }
            shop.AUTOBAGAZ_SHOP_DATE = DateTime.Now.ToString("g");
            shop.AUTOBAGAZ_SHOP_STATUS_ID = 3;
            shop.AUTOBAGAZ_SHOP_USER_ID = User.Identity.GetUserId<int>();
            _context.Update(shop);
            await _context.SaveChangesAsync();

            return RedirectToAction(nameof(Index));
        }

        [Authorize(Roles = "admin")]
        public async Task<IActionResult> RestoreShop(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var shop = await _context.AUTOBAGAZ_SHOP.FindAsync(id);
            if (shop == null)
            {
                return NotFound();
            }

            return View(shop);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> RestoreShop(int id, Shop shop)
        {
            if (id != shop.AUTOBAGAZ_SHOP_ID)
            {
                return NotFound();
            }

            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL1 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL1 = "";
            }
            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL2 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL2 = "";
            }
            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL3 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL3 = "";
            }
            if (shop.AUTOBAGAZ_SHOP_PHOTO_URL4 == null)
            {
                shop.AUTOBAGAZ_SHOP_PHOTO_URL4 = "";
            }
            shop.AUTOBAGAZ_SHOP_DATE = DateTime.Now.ToString("g");
            shop.AUTOBAGAZ_SHOP_STATUS_ID = 1;
            shop.AUTOBAGAZ_SHOP_USER_ID = User.Identity.GetUserId<int>();
            _context.Update(shop);
            await _context.SaveChangesAsync();

            return RedirectToAction(nameof(Index));
        }

        private bool ShopExists(int id)
        {
            return _context.AUTOBAGAZ_SHOP.Any(e => e.AUTOBAGAZ_SHOP_ID == id);
        }
    }
}
