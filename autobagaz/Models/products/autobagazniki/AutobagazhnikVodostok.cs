using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Автобагажник на водосток
    /// </summary>
    [Table("AUTOBAGAZHIK_VODOSTOK")]
    public class AutobagazhnikVodostok
    {
        /// <summary>
        /// ИД Автобагажника на водосток
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZHIK_VODOSTOK_ID { get; set; }
        /// <summary>
        /// Имя Автобагажника на водосток
        /// </summary>
        [Required]
        public string AUTOBAGAZHIK_VODOSTOK_NAME { get; set; }
        /// <summary>
        /// Имя изображения для Автобагажника на водосток
        /// </summary>
        public string AUTOBAGAZHIK_VODOSTOK_FILE_NAME { get; set; }
        /// <summary>
        /// Путь до файла с изображением для Автобагажника на водосток
        /// </summary>
        public string AUTOBAGAZHIK_VODOSTOK_FILE_PATH { get; set; }
        /// <summary>
        /// Описание Автобагажника на водосток
        /// </summary>
        public string AUTOBAGAZHIK_VODOSTOK_DESCRIPTION { get; set; }
        /// <summary>
        /// Дата создания/изменения Автобагажника на водосток
        /// </summary>
        public DateTime AUTOBAGAZHIK_VODOSTOK_DATE { get; set; }
        /// <summary>
        /// Ссылка на статус Автобагажника на водосток
        /// </summary>
        [ForeignKey("VODOSTOK_STATUS")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZHIK_VODOSTOK_STATUS_ID { get; set; }
        /// <summary>
        /// Ссылка на пользователя, который добавил/изменил Автобагажник на водосток
        /// </summary>
        [ForeignKey("VODOSTOK_USER")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZHIK_VODOSTOK_USER_ID { get; set; }
    }
}
