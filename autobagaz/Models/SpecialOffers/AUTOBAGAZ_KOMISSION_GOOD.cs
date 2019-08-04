using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Комиссионный товар
    /// </summary>
    [Table("AUTOBAGAZ_KOMISSION_GOODS")]
    public class AUTOBAGAZ_KOMISSION_GOOD
    {
        /// <summary>
        /// ИД товара комиссионки
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZ_KOMISSION_GOOD_ID { get; set; }
        /// <summary>
        /// Наименование товара комиссионки
        /// </summary>
        [Required]
        public string AUTOBAGAZ_KOMISSION_GOOD_NAME { get; set; }
        /// <summary>
        /// Ссылка на фото 1 товара комиссионки
        /// </summary>
        public string AUTOBAGAZ_KOMISSION_GOOD_PHOTO1 { get; set; }
        /// <summary>
        /// Ссылка на фото 2 товара комиссионки
        /// </summary>
        public string AUTOBAGAZ_KOMISSION_GOOD_PHOTO2 { get; set; }
        /// <summary>
        /// Ссылка на фото 3 товара комиссионки
        /// </summary>
        public string AUTOBAGAZ_KOMISSION_GOOD_PHOTO3 { get; set; }
        /// <summary>
        /// Ссылка на фото 4 товара комиссионки
        /// </summary>
        public string AUTOBAGAZ_KOMISSION_GOOD_PHOTO4 { get; set; }
        /// <summary>
        /// Ссылка на фото 5 товара комиссионки
        /// </summary>
        public string AUTOBAGAZ_KOMISSION_GOOD_PHOTO5 { get; set; }
        /// <summary>
        /// Категория товара комиссионки
        /// </summary>
        public string AUTOBAGAZ_KOMISSION_GOOD_TYPE { get; set; }
        /// <summary>
        /// Цена товара комиссионки
        /// </summary>
        public string AUTOBAGAZ_KOMISSION_GOOD_PRICE { get; set; }
        /// <summary>
        /// Дата изменения товара комиссионки
        /// </summary>
        [Required]
        public string AUTOBAGAZ_KOMISSION_DATE { get; set; }
        /// <summary>
        /// Статус товара комиссионки
        /// </summary>
        [Required]
        public int KOMISSION_STATUS_ID { get; set; }
        [ForeignKey("KOMISSION_STATUS_ID")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZ_STATUS { get; set; }
        /// <summary>
        /// Пользователь изменивший товар комиссионки
        /// </summary>
        [Required]
        public int KOMISSION_USER_ID { get; set; }
        [ForeignKey("KOMISSION_USER_ID")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZ_USER { get; set; }
    }
}
