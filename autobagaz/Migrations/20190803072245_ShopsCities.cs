using Microsoft.EntityFrameworkCore.Metadata;
using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class ShopsCities : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_CITY",
                columns: table => new
                {
                    AUTOBAGAZ_CITY_ID = table.Column<int>(nullable: false)
                        .Annotation("MySql:ValueGenerationStrategy", MySqlValueGenerationStrategy.IdentityColumn),
                    AUTOBAGAZ_CITY_NAME = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_CITY", x => x.AUTOBAGAZ_CITY_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_WORKTIME",
                columns: table => new
                {
                    WORKTIME_ID = table.Column<int>(nullable: false)
                        .Annotation("MySql:ValueGenerationStrategy", MySqlValueGenerationStrategy.IdentityColumn),
                    WORKTIME_STARTTIME_WEEK = table.Column<string>(nullable: true),
                    WORKTIME_ENDTIME_WEEK = table.Column<string>(nullable: true),
                    WORKTIME_STARTTIME_WEEKEND = table.Column<string>(nullable: true),
                    WORKTIME_ENDTIME_WEEKEND = table.Column<string>(nullable: true),
                    WORKTIME_EMAIL = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_WORKTIME", x => x.WORKTIME_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_SHOP",
                columns: table => new
                {
                    AUTOBAGAZ_SHOP_ID = table.Column<int>(nullable: false)
                        .Annotation("MySql:ValueGenerationStrategy", MySqlValueGenerationStrategy.IdentityColumn),
                    AUTOBAGAZ_SHOP_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SHOP_PHONE = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SHOP_PERSON = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SHOP_PHOTO_URL1 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SHOP_PHOTO_URL2 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SHOP_PHOTO_URL3 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SHOP_PHOTO_URL4 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SHOP_MAP = table.Column<string>(nullable: true),
                    AUTOBAGAZ_CITY_ID = table.Column<int>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_SHOP", x => x.AUTOBAGAZ_SHOP_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_CITY_AUTOBAGAZ_CITY_ID",
                        column: x => x.AUTOBAGAZ_CITY_ID,
                        principalTable: "AUTOBAGAZ_CITY",
                        principalColumn: "AUTOBAGAZ_CITY_ID",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_SHOP_AUTOBAGAZ_CITY_ID",
                table: "AUTOBAGAZ_SHOP",
                column: "AUTOBAGAZ_CITY_ID");
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_WORKTIME");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_CITY");
        }
    }
}
