using Microsoft.EntityFrameworkCore.Metadata;
using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class SpecialOffers : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_KOMISSION_GOODS",
                columns: table => new
                {
                    AUTOBAGAZ_KOMISSION_GOOD_ID = table.Column<int>(nullable: false)
                        .Annotation("MySql:ValueGenerationStrategy", MySqlValueGenerationStrategy.IdentityColumn),
                    AUTOBAGAZ_KOMISSION_GOOD_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZ_KOMISSION_GOOD_PHOTO1 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_KOMISSION_GOOD_PHOTO2 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_KOMISSION_GOOD_PHOTO3 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_KOMISSION_GOOD_PHOTO4 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_KOMISSION_GOOD_PHOTO5 = table.Column<string>(nullable: true),
                    AUTOBAGAZ_KOMISSION_GOOD_TYPE = table.Column<string>(nullable: true),
                    AUTOBAGAZ_KOMISSION_GOOD_PRICE = table.Column<string>(nullable: true),
                    AUTOBAGAZ_KOMISSION_DATE = table.Column<string>(nullable: false),
                    KOMISSION_STATUS_ID = table.Column<int>(nullable: false),
                    KOMISSION_USER_ID = table.Column<int>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_KOMISSION_GOODS", x => x.AUTOBAGAZ_KOMISSION_GOOD_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZ_KOMISSION_GOODS_AUTOBAGAZ_STATUS_KOMISSION_STATUS_~",
                        column: x => x.KOMISSION_STATUS_ID,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZ_KOMISSION_GOODS_AUTOBAGAZ_USERS_KOMISSION_USER_ID",
                        column: x => x.KOMISSION_USER_ID,
                        principalTable: "AUTOBAGAZ_USERS",
                        principalColumn: "AUTOBAGAZ_USER_ID",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_SPECIAL_GOODS",
                columns: table => new
                {
                    AUTOBAGAZ_SPECIAL_OFFER_ID = table.Column<int>(nullable: false)
                        .Annotation("MySql:ValueGenerationStrategy", MySqlValueGenerationStrategy.IdentityColumn),
                    AUTOBAGAZ_SPECIAL_OFFER_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZ_SPECIAL_OFFER_PHOTO = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SPECIAL_OFFER_PRICE = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SPECIAL_OFFER_OLDPRICE = table.Column<string>(nullable: true),
                    AUTOBAGAZ_SPECIAL_OFFER_DATE = table.Column<string>(nullable: false),
                    SPECIAL_OFFER_STATUS_ID = table.Column<int>(nullable: false),
                    SPECIAL_OFFER_USER_ID = table.Column<int>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_SPECIAL_GOODS", x => x.AUTOBAGAZ_SPECIAL_OFFER_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZ_SPECIAL_GOODS_AUTOBAGAZ_STATUS_SPECIAL_OFFER_STATU~",
                        column: x => x.SPECIAL_OFFER_STATUS_ID,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZ_SPECIAL_GOODS_AUTOBAGAZ_USERS_SPECIAL_OFFER_USER_ID",
                        column: x => x.SPECIAL_OFFER_USER_ID,
                        principalTable: "AUTOBAGAZ_USERS",
                        principalColumn: "AUTOBAGAZ_USER_ID",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_KOMISSION_GOODS_KOMISSION_STATUS_ID",
                table: "AUTOBAGAZ_KOMISSION_GOODS",
                column: "KOMISSION_STATUS_ID");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_KOMISSION_GOODS_KOMISSION_USER_ID",
                table: "AUTOBAGAZ_KOMISSION_GOODS",
                column: "KOMISSION_USER_ID");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_SPECIAL_GOODS_SPECIAL_OFFER_STATUS_ID",
                table: "AUTOBAGAZ_SPECIAL_GOODS",
                column: "SPECIAL_OFFER_STATUS_ID");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_SPECIAL_GOODS_SPECIAL_OFFER_USER_ID",
                table: "AUTOBAGAZ_SPECIAL_GOODS",
                column: "SPECIAL_OFFER_USER_ID");
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_KOMISSION_GOODS");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_SPECIAL_GOODS");
        }
    }
}
