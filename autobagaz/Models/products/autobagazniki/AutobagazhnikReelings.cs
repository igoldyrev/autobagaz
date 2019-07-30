using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Автобагажник на рейлинги
    /// </summary>
    [Table("AUTOBAGAZHIK_REELINGS")]
    public class AutobagazhnikReelings
    {
        /// <summary>
        /// ИД Автобагажника на рейлинги
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZHIK_REELINGS_ID { get; set; }
        /// <summary>
        /// Имя Автобагажника на рейлинги
        /// </summary>
        [Required]
        public string AUTOBAGAZHIK_REELINGS_NAME { get; set; }
        /// <summary>
        /// Имя изображения для Автобагажника на рейлинги
        /// </summary>
        public string AUTOBAGAZHIK_REELINGS_FILE_NAME { get; set; }
        /// <summary>
        /// Путь до файла с изображением для Автобагажника на рейлинги
        /// </summary>
        public string AUTOBAGAZHIK_REELINGS_FILE_PATH { get; set; }
        /// <summary>
        /// Описание Автобагажника на рейлинги
        /// </summary>
        public string AUTOBAGAZHIK_REELINGS_DESCRIPTION { get; set; }
        /// <summary>
        /// Дата создания/изменения Автобагажника на рейлинги
        /// </summary>
        public DateTime AUTOBAGAZHIK_REELINGS_DATE { get; set; }
        /// <summary>
        /// Ссылка на статус Автобагажника на рейлинги
        /// </summary>
        [ForeignKey("REELINGS_STATUS")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZHIK_REELINGS_STATUS_ID { get; set; }
        /// <summary>
        /// Ссылка на пользователя, который добавил/изменил Автобагажник на рейлинги
        /// </summary>
        [ForeignKey("REELINGS_USER")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZHIK_REELINGS_USER_ID { get; set; }
    }
}
