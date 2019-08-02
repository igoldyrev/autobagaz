using System.ComponentModel;
using System.ComponentModel.DataAnnotations;

namespace autobagaz
{
    public class LoginViewModel
    {
        /// <summary>
        /// Имя пользователя
        /// </summary>
        [Required]
        [DisplayName("Имя пользователя")]
        public string USERNAME { get; set; }
        /// <summary>
        /// Пароль пользователя
        /// </summary>
        [Required]
        [DisplayName("Пароль")]
        [DataType(DataType.Password)]
        public string PASSWORD { get; set; }
    }
}
