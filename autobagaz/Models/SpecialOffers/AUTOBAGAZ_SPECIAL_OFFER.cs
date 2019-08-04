using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Специальные предложения
    /// </summary>
    [Table("AUTOBAGAZ_SPECIAL_GOODS")]
    public class AUTOBAGAZ_SPECIAL_OFFER
    {
        /// <summary>
        /// ИД спецпредложения
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZ_SPECIAL_OFFER_ID { get; set; }
        /// <summary>
        /// Наименование спецпредложения
        /// </summary>
        [Required]
        public string AUTOBAGAZ_SPECIAL_OFFER_NAME { get; set; }
        /// <summary>
        /// Изображение спецпредложения
        /// </summary>
        public string AUTOBAGAZ_SPECIAL_OFFER_PHOTO { get; set; }
        /// <summary>
        /// Цена спецпредложения
        /// </summary>
        public string AUTOBAGAZ_SPECIAL_OFFER_PRICE { get; set; }
        /// <summary>
        /// Старая цена спецпредложения
        /// </summary>
        public string AUTOBAGAZ_SPECIAL_OFFER_OLDPRICE { get; set; }
        /// <summary>
        /// Дата изменения спецпредложения
        /// </summary>
        [Required]
        public string AUTOBAGAZ_SPECIAL_OFFER_DATE { get; set; }
        /// <summary>
        /// Статус спецпредложения
        /// </summary>
        [Required]
        public int SPECIAL_OFFER_STATUS_ID { get; set; }
        [ForeignKey("SPECIAL_OFFER_STATUS_ID")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZ_STATUS { get; set; }
        /// <summary>
        /// Пользователь изменивший спецпредложение
        /// </summary>
        [Required]
        public int SPECIAL_OFFER_USER_ID { get; set; }
        [ForeignKey("SPECIAL_OFFER_USER_ID")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZ_USER { get; set; }
    }
}
