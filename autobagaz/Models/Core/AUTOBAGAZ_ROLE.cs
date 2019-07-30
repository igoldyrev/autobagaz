using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Роль пользователя
    /// </summary>
    [Table("AUTOBAGAZ_ROLE")]
    public class AUTOBAGAZ_ROLE
    {
        /// <summary>
        /// ИД роли
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZ_ROLE_ID { get; set; }
        /// <summary>
        /// Имя роли
        /// </summary>
        [Required]
        public string AUTOBAGAZ_ROLE_NAME { get; set; }
        /// <summary>
        /// Описание роли
        /// </summary>
        [Required]
        public string AUTOBAGAZ_ROLE_DESCRIPTION { get; set; }
    }
}
