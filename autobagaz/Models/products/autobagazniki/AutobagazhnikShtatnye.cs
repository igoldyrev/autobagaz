using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Автобагажник в штатные места
    /// </summary>
    [Table("AUTOBAGAZHIK_SHTATNYE")]
    public class AutobagazhnikShtatnye
    {
        /// <summary>
        /// ИД Автобагажника в штатные места
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZHIK_SHTATNYE_ID { get; set; }
        /// <summary>
        /// Имя Автобагажника в штатные места
        /// </summary>
        [Required]
        public string AUTOBAGAZHIK_SHTATNYE_NAME { get; set; }
        /// <summary>
        /// Имя изображения для Автобагажника в штатные места
        /// </summary>
        public string AUTOBAGAZHIK_SHTATNYE_FILE_NAME { get; set; }
        /// <summary>
        /// Путь до файла с изображением для Автобагажника в штатные места
        /// </summary>
        public string AUTOBAGAZHIK_SHTATNYE_FILE_PATH { get; set; }
        /// <summary>
        /// Описание Автобагажника в штатные места
        /// </summary>
        public string AUTOBAGAZHIK_SHTATNYE_DESCRIPTION { get; set; }
        /// <summary>
        /// Дата создания/изменения Автобагажника в штатные места
        /// </summary>
        public DateTime AUTOBAGAZHIK_SHTATNYE_DATE { get; set; }
        /// <summary>
        /// Ссылка на статус Автобагажника в штатные места
        /// </summary>
        [ForeignKey("SHTATNYE_STATUS")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZHIK_SHTATNYE_STATUS_ID { get; set; }
        /// <summary>
        /// Ссылка на пользователя, который добавил/изменил Автобагажник в штатные места
        /// </summary>
        [ForeignKey("SHTATNYE_USER")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZHIK_SHTATNYE_USER_ID { get; set; }
    }
}
