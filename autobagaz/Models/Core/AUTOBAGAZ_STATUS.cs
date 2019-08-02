using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Статус объекта
    /// </summary>
    [Table("AUTOBAGAZ_STATUS")]
    public class AUTOBAGAZ_STATUS
    {
        /// <summary>
        /// ИД статуса
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZ_STATUS_ID { get; set; }
        /// <summary>
        /// Код статуса
        /// </summary>
        [Required]
        public string AUTOBAGAZ_STATUS_CODE { get; set; }
        /// <summary>
        /// Наименование статуса
        /// </summary>
        [Required]
        public string AUTOBAGAZ_STATUS_NAME { get; set; }
    }
}
