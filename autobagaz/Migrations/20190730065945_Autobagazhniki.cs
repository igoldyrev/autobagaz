using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class Autobagazhniki : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK",
                columns: table => new
                {
                    AUTOBAGAZHIK_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_DESCRIPTION = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK", x => x.AUTOBAGAZHIK_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_REELINGS",
                columns: table => new
                {
                    AUTOBAGAZHIK_REELINGS_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_REELINGS_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_REELINGS_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_REELINGS_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_REELINGS_DESCRIPTION = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_REELINGS", x => x.AUTOBAGAZHIK_REELINGS_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_SHTATNYE",
                columns: table => new
                {
                    AUTOBAGAZHIK_SHTATNYE_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_SHTATNYE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SHTATNYE_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SHTATNYE_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SHTATNYE_DESCRIPTION = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_SHTATNYE", x => x.AUTOBAGAZHIK_SHTATNYE_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_SMOOTH",
                columns: table => new
                {
                    AUTOBAGAZHIK_SMOOTH_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_SMOOTH_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SMOOTH_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SMOOTH_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SMOOTH_DESCRIPTION = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_SMOOTH", x => x.AUTOBAGAZHIK_SMOOTH_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_VODOSTOK",
                columns: table => new
                {
                    AUTOBAGAZHIK_VODOSTOK_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_VODOSTOK_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_VODOSTOK_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_VODOSTOK_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_VODOSTOK_DESCRIPTION = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_VODOSTOK", x => x.AUTOBAGAZHIK_VODOSTOK_ID);
                });
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "AUTOBAGAZHIK");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZHIK_REELINGS");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZHIK_SHTATNYE");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZHIK_SMOOTH");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZHIK_VODOSTOK");
        }
    }
}
