using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace autobagaz
{
    [Table("AUTOBAGAZHIK_VODOSTOK")]
    public class AutobagazhnikVodostok
    {
        [Key]
        public int AUTOBAGAZHIK_VODOSTOK_ID { get; set; }
        public string AUTOBAGAZHIK_VODOSTOK_NAME { get; set; }
        public string AUTOBAGAZHIK_VODOSTOK_FILE_NAME { get; set; }
        public string AUTOBAGAZHIK_VODOSTOK_FILE_PATH { get; set; }
        public string AUTOBAGAZHIK_VODOSTOK_DESCRIPTION { get; set; }
    }
}
