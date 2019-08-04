using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class ShopsCitiesUpdate : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_CITY_AUTOBAGAZ_CITY_ID",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.AlterColumn<int>(
                name: "AUTOBAGAZ_CITY_ID",
                table: "AUTOBAGAZ_SHOP",
                nullable: false,
                oldClrType: typeof(int),
                oldNullable: true);

            migrationBuilder.AddForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_CITY_AUTOBAGAZ_CITY_ID",
                table: "AUTOBAGAZ_SHOP",
                column: "AUTOBAGAZ_CITY_ID",
                principalTable: "AUTOBAGAZ_CITY",
                principalColumn: "AUTOBAGAZ_CITY_ID",
                onDelete: ReferentialAction.Cascade);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_CITY_AUTOBAGAZ_CITY_ID",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.AlterColumn<int>(
                name: "AUTOBAGAZ_CITY_ID",
                table: "AUTOBAGAZ_SHOP",
                nullable: true,
                oldClrType: typeof(int));

            migrationBuilder.AddForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_CITY_AUTOBAGAZ_CITY_ID",
                table: "AUTOBAGAZ_SHOP",
                column: "AUTOBAGAZ_CITY_ID",
                principalTable: "AUTOBAGAZ_CITY",
                principalColumn: "AUTOBAGAZ_CITY_ID",
                onDelete: ReferentialAction.Restrict);
        }
    }
}
