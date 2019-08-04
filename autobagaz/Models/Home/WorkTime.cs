using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Время работы
    /// </summary>
    [Table("AUTOBAGAZ_WORKTIME")]
    public class WorkTime
    {
        /// <summary>
        /// ИД
        /// </summary>
        [Key]
        [Required]
        public int WORKTIME_ID { get; set; }
        /// <summary>
        /// Начало работы в будни
        /// </summary>
        public string WORKTIME_STARTTIME_WEEK { get; set; }
        /// <summary>
        /// Окончание работы в будни
        /// </summary>
        public string WORKTIME_ENDTIME_WEEK { get; set; }
        /// <summary>
        /// Начало работы в выходные
        /// </summary>
        public string WORKTIME_STARTTIME_WEEKEND { get; set; }
        /// <summary>
        /// Окончание работы в выходные
        /// </summary>
        public string WORKTIME_ENDTIME_WEEKEND { get; set; }
        /// <summary>
        /// Электронная почта магазина
        /// </summary>
        public string WORKTIME_EMAIL { get; set; }
    }
}
