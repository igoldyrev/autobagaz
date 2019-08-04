using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Магазин
    /// </summary>
    [Table("AUTOBAGAZ_SHOP")]
    public class Shop
    {
        /// <summary>
        /// ИД магазина
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZ_SHOP_ID { get; set; }
        /// <summary>
        /// Название/адрес магазина
        /// </summary>
        public string AUTOBAGAZ_SHOP_NAME { get; set; }
        /// <summary>
        /// Телефон магазина
        /// </summary>
        public string AUTOBAGAZ_SHOP_PHONE { get; set; }
        /// <summary>
        /// Человек в магазине
        /// </summary>
        public string AUTOBAGAZ_SHOP_PERSON { get; set; }
        /// <summary>
        /// Изображение Магазина 1
        /// </summary>
        public string AUTOBAGAZ_SHOP_PHOTO_URL1 { get; set; }
        /// <summary>
        /// Изображение Магазина 2
        /// </summary>
        public string AUTOBAGAZ_SHOP_PHOTO_URL2 { get; set; }
        /// <summary>
        /// Изображение Магазина 3
        /// </summary>
        public string AUTOBAGAZ_SHOP_PHOTO_URL3 { get; set; }
        /// <summary>
        /// Изображение Магазина 4
        /// </summary>
        public string AUTOBAGAZ_SHOP_PHOTO_URL4 { get; set; }
        /// <summary>
        /// Код яндекс карты
        /// </summary>
        public string AUTOBAGAZ_SHOP_MAP { get; set; }
        /// <summary>
        /// ИД города в котором находится магазин
        /// </summary>
        public int AUTOBAGAZ_CITY_ID { get; set; }
        [ForeignKey("AUTOBAGAZ_CITY_ID")]
        public virtual City City { get; set; }
    }
}
