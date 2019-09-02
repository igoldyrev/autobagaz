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

            IQueryable<Shop> cities = _context.AUTOBAGAZ_SHOP.Include(s => s.City);
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

        // GET: Contacts/Details/5
        //public async Task<IActionResult> Details(int? id)
        //{
        //    if (id == null)
        //    {
        //        return NotFound();
        //    }

        //    var shop = await _context.AUTOBAGAZ_SHOP
        //        .Include(s => s.AUTOBAGAZ_STATUS)
        //        .Include(s => s.AUTOBAGAZ_USER)
        //        .Include(s => s.City)
        //        .FirstOrDefaultAsync(m => m.AUTOBAGAZ_SHOP_ID == id);
        //    if (shop == null)
        //    {
        //        return NotFound();
        //    }

        //    return View(shop);
        //}

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
                else if (shop.AUTOBAGAZ_SHOP_PHOTO_URL2 == null)
                {
                    shop.AUTOBAGAZ_SHOP_PHOTO_URL2 = "";
                }
                else if (shop.AUTOBAGAZ_SHOP_PHOTO_URL3 == null)
                {
                    shop.AUTOBAGAZ_SHOP_PHOTO_URL3 = "";
                }
                else if (shop.AUTOBAGAZ_SHOP_PHOTO_URL4 == null)
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
        public async Task<IActionResult> Edit(int? id)
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
            ViewData["AUTOBAGAZ_SHOP_STATUS_ID"] = new SelectList(_context.AUTOBAGAZ_STATUS, "AUTOBAGAZ_STATUS_ID", "AUTOBAGAZ_STATUS_CODE", shop.AUTOBAGAZ_SHOP_STATUS_ID);
            ViewData["AUTOBAGAZ_SHOP_USER_ID"] = new SelectList(_context.AUTOBAGAZ_USER, "AUTOBAGAZ_USER_ID", "AUTOBAGAZ_USER_DATE", shop.AUTOBAGAZ_SHOP_USER_ID);
            ViewData["AUTOBAGAZ_CITY_ID"] = new SelectList(_context.AUTOBAGAZ_CITY, "AUTOBAGAZ_CITY_ID", "AUTOBAGAZ_CITY_NAME", shop.AUTOBAGAZ_CITY_ID);
            return View(shop);
        }

        // POST: Contacts/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(int id, [Bind("AUTOBAGAZ_SHOP_ID,AUTOBAGAZ_SHOP_NAME,AUTOBAGAZ_SHOP_PHONE,AUTOBAGAZ_SHOP_PERSON_PHONE1,AUTOBAGAZ_SHOP_PERSON_NAME1,AUTOBAGAZ_SHOP_PERSON_PHONE2,AUTOBAGAZ_SHOP_PERSON_NAME2,AUTOBAGAZ_SHOP_PHOTO_URL1,AUTOBAGAZ_SHOP_PHOTO_URL2,AUTOBAGAZ_SHOP_PHOTO_URL3,AUTOBAGAZ_SHOP_PHOTO_URL4,AUTOBAGAZ_SHOP_MAP,AUTOBAGAZ_CITY_ID,AUTOBAGAZ_SHOP_DATE,AUTOBAGAZ_SHOP_STATUS_ID,AUTOBAGAZ_SHOP_USER_ID")] Shop shop)
        {
            if (id != shop.AUTOBAGAZ_SHOP_ID)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
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
            ViewData["AUTOBAGAZ_SHOP_STATUS_ID"] = new SelectList(_context.AUTOBAGAZ_STATUS, "AUTOBAGAZ_STATUS_ID", "AUTOBAGAZ_STATUS_CODE", shop.AUTOBAGAZ_SHOP_STATUS_ID);
            ViewData["AUTOBAGAZ_SHOP_USER_ID"] = new SelectList(_context.AUTOBAGAZ_USER, "AUTOBAGAZ_USER_ID", "AUTOBAGAZ_USER_DATE", shop.AUTOBAGAZ_SHOP_USER_ID);
            ViewData["AUTOBAGAZ_CITY_ID"] = new SelectList(_context.AUTOBAGAZ_CITY, "AUTOBAGAZ_CITY_ID", "AUTOBAGAZ_CITY_NAME", shop.AUTOBAGAZ_CITY_ID);
            return View(shop);
        }

        // GET: Contacts/Delete/5
        public async Task<IActionResult> Delete(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var shop = await _context.AUTOBAGAZ_SHOP
                .Include(s => s.AUTOBAGAZ_STATUS)
                .Include(s => s.AUTOBAGAZ_USER)
                .Include(s => s.City)
                .FirstOrDefaultAsync(m => m.AUTOBAGAZ_SHOP_ID == id);
            if (shop == null)
            {
                return NotFound();
            }

            return View(shop);
        }

        // POST: Contacts/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(int id)
        {
            var shop = await _context.AUTOBAGAZ_SHOP.FindAsync(id);
            _context.AUTOBAGAZ_SHOP.Remove(shop);
            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }

        private bool ShopExists(int id)
        {
            return _context.AUTOBAGAZ_SHOP.Any(e => e.AUTOBAGAZ_SHOP_ID == id);
        }
    }
}
