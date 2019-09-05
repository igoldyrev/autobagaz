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
        [Required]
        public string AUTOBAGAZ_SHOP_NAME { get; set; }
        /// <summary>
        /// Телефон магазина
        /// </summary>
        [Required]
        public string AUTOBAGAZ_SHOP_PHONE { get; set; }
        /// <summary>
        /// Номер телефона первого менеджера в магазине
        /// </summary>
        public string AUTOBAGAZ_SHOP_PERSON_PHONE1 { get; set; }
        /// <summary>
        /// Имя первого менеджера в магазине
        /// </summary>
        public string AUTOBAGAZ_SHOP_PERSON_NAME1 { get; set; }
        /// <summary>
        /// Номер телефона второго менеджера в магазине
        /// </summary>
        public string AUTOBAGAZ_SHOP_PERSON_PHONE2 { get; set; }
        /// <summary>
        /// Имя второго менеджера в магазине
        /// </summary>
        public string AUTOBAGAZ_SHOP_PERSON_NAME2 { get; set; }
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
        /// <summary>
        /// Дата изменения магазина
        /// </summary>
        public string AUTOBAGAZ_SHOP_DATE { get; set; }
        /// <summary>
        /// Статус магазина
        /// </summary>
        [Required]
        public int AUTOBAGAZ_SHOP_STATUS_ID { get; set; }
        [ForeignKey("AUTOBAGAZ_SHOP_STATUS_ID")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZ_STATUS { get; set; }
        /// <summary>
        /// Пользователь изменивший магазин
        /// </summary>
        [Required]
        public int AUTOBAGAZ_SHOP_USER_ID { get; set; }
        [ForeignKey("AUTOBAGAZ_SHOP_USER_ID")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZ_USER { get; set; }
    }
}
