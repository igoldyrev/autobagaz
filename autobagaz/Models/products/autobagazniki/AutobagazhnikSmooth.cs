using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Автобагажник на гладкую крышу
    /// </summary>
    [Table("AUTOBAGAZHIK_SMOOTH")]
    public class AutobagazhnikSmooth
    {
        /// <summary>
        /// ИД Автобагажника на гладкую крышу
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZHIK_SMOOTH_ID { get; set; }
        /// <summary>
        /// Имя Автобагажника на гладкую крышу
        /// </summary>
        [Required]
        public string AUTOBAGAZHIK_SMOOTH_NAME { get; set; }
        /// <summary>
        /// Имя изображения для Автобагажника на гладкую крышу
        /// </summary>
        public string AUTOBAGAZHIK_SMOOTH_FILE_NAME { get; set; }
        /// <summary>
        /// Путь до файла с изображением для Автобагажника на гладкую крышу
        /// </summary>
        public string AUTOBAGAZHIK_SMOOTH_FILE_PATH { get; set; }
        /// <summary>
        /// Описание Автобагажника на гладкую крышу
        /// </summary>
        public string AUTOBAGAZHIK_SMOOTH_DESCRIPTION { get; set; }
        /// <summary>
        /// Дата создания/изменения Автобагажника на гладкую крышу
        /// </summary>
        public DateTime AUTOBAGAZHIK_SMOOTH_DATE { get; set; }
        /// <summary>
        /// Ссылка на статус Автобагажника на гладкую крышу
        /// </summary>
        [ForeignKey("SMOOTH_STATUS")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZHIK_SMOOTH_STATUS_ID { get; set; }
        /// <summary>
        /// Ссылка на пользователя, который добавил/изменил Автобагажник на гладкую крышу
        /// </summary>
        [ForeignKey("SMOOTH_USER")]
        public virtual AUTOBAGAZ_USER AUTOBAGAZHIK_SMOOTH_USER_ID { get; set; }
    }
}
