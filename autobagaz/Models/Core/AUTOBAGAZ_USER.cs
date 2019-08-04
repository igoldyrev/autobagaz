using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    /// <summary>
    /// Пользователь
    /// </summary>
    [Table("AUTOBAGAZ_USERS")]
    public class AUTOBAGAZ_USER
    {
        /// <summary>
        /// ИД Пользователя
        /// </summary>
        [Key]
        [Required]
        public int AUTOBAGAZ_USER_ID { get; set; }
        /// <summary>
        /// Имя Пользователя
        /// </summary>
        [Required]
        public string AUTOBAGAZ_USER_NAME { get; set; }
        /// <summary>
        /// Email Пользователя
        /// </summary>
        [Required]
        public string AUTOBAGAZ_USER_EMAIL { get; set; }
        /// <summary>
        /// Пароль Пользователя
        /// </summary>
        [Required]
        [DataType(DataType.Password)]
        public string AUTOBAGAZ_USER_PASSWORD { get; set; }
        /// <summary>
        /// Активность Пользователя
        /// </summary>
        [Required]
        public bool AUTOBAGAZ_USER_IS_ACTIVE { get; set; }
        /// <summary>
        /// ИД Роли Пользователя
        /// </summary>
        [Required]
        public int AUTOBAGAZ_USER_ROLE_ID { get; set; }
        /// <summary>
        /// Роль Пользователя
        /// </summary>
        [ForeignKey("AUTOBAGAZ_USER_ROLE_ID")]
        public virtual AUTOBAGAZ_ROLE AUTOBAGAZ_ROLE { get; set; }
        /// <summary>
        /// Дата регистрации/изменения пользователя
        /// </summary>
        [Required]
        public string AUTOBAGAZ_USER_DATE { get; set; }
        /// <summary>
        /// ИД Статуса Пользователя
        /// </summary>
        [Required]
        public int AUTOBAGAZ_USER_STATUS_ID { get; set; }
        /// <summary>
        /// Статус Пользователя
        /// </summary>
        [ForeignKey("AUTOBAGAZ_USER_STATUS_ID")]
        public virtual AUTOBAGAZ_STATUS AUTOBAGAZ_STATUS { get; set; }
    }
}
