using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Автобагажник
    /// </summary>
    [Table("AUTOBAGAZHIK")]
    public class Autobagazhnik
    {
        /// <summary>
        /// ИД Автобагажника
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZHIK_ID { get; set; }
        /// <summary>
        /// Имя Автобагажника
        /// </summary>
        [Required]
        public string AUTOBAGAZHIK_NAME { get; set; }
        /// <summary>
        /// Имя изображения для Автобагажника
        /// </summary>
        public string AUTOBAGAZHIK_FILE_NAME { get; set; }
        /// <summary>
        /// Путь до файла с изображением для Автобагажника
        /// </summary>
        public string AUTOBAGAZHIK_FILE_PATH { get; set; }
        /// <summary>
        /// Описание Автобагажника
        /// </summary>
        public string AUTOBAGAZHIK_DESCRIPTION { get; set; }
        /// <summary>
        /// Дата создания/изменения Автобагажника
        /// </summary>
        public DateTime AUTOBAGAZHIK_DATE { get; set; }
        /// <summary>
        /// Ссылка на статус Автобагажника
        /// </summary>
        [ForeignKey("AUTOBAGAZHIK_STATUS")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZHIK_STATUS_ID { get; set; }
        /// <summary>
        /// Ссылка на пользователя, который добавил/изменил Автобагажник
        /// </summary>
        [ForeignKey("AUTOBAGAZHIK_USER")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZHIK_USER_ID { get; set; }
    }
}
