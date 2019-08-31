using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class ShopTechnicalInfo : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<string>(
                name: "AUTOBAGAZ_SHOP_DATE",
                table: "AUTOBAGAZ_SHOP",
                nullable: true);

            migrationBuilder.AddColumn<int>(
                name: "AUTOBAGAZ_SHOP_STATUS_ID",
                table: "AUTOBAGAZ_SHOP",
                nullable: false,
                defaultValue: 0);

            migrationBuilder.AddColumn<int>(
                name: "AUTOBAGAZ_SHOP_USER_ID",
                table: "AUTOBAGAZ_SHOP",
                nullable: false,
                defaultValue: 0);

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_SHOP_AUTOBAGAZ_SHOP_STATUS_ID",
                table: "AUTOBAGAZ_SHOP",
                column: "AUTOBAGAZ_SHOP_STATUS_ID");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_SHOP_AUTOBAGAZ_SHOP_USER_ID",
                table: "AUTOBAGAZ_SHOP",
                column: "AUTOBAGAZ_SHOP_USER_ID");

            migrationBuilder.AddForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_STATUS_AUTOBAGAZ_SHOP_STATUS_ID",
                table: "AUTOBAGAZ_SHOP",
                column: "AUTOBAGAZ_SHOP_STATUS_ID",
                principalTable: "AUTOBAGAZ_STATUS",
                principalColumn: "AUTOBAGAZ_STATUS_ID",
                onDelete: ReferentialAction.Cascade);

            migrationBuilder.AddForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_USERS_AUTOBAGAZ_SHOP_USER_ID",
                table: "AUTOBAGAZ_SHOP",
                column: "AUTOBAGAZ_SHOP_USER_ID",
                principalTable: "AUTOBAGAZ_USERS",
                principalColumn: "AUTOBAGAZ_USER_ID",
                onDelete: ReferentialAction.Cascade);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_STATUS_AUTOBAGAZ_SHOP_STATUS_ID",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropForeignKey(
                name: "FK_AUTOBAGAZ_SHOP_AUTOBAGAZ_USERS_AUTOBAGAZ_SHOP_USER_ID",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropIndex(
                name: "IX_AUTOBAGAZ_SHOP_AUTOBAGAZ_SHOP_STATUS_ID",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropIndex(
                name: "IX_AUTOBAGAZ_SHOP_AUTOBAGAZ_SHOP_USER_ID",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropColumn(
                name: "AUTOBAGAZ_SHOP_DATE",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropColumn(
                name: "AUTOBAGAZ_SHOP_STATUS_ID",
                table: "AUTOBAGAZ_SHOP");

            migrationBuilder.DropColumn(
                name: "AUTOBAGAZ_SHOP_USER_ID",
                table: "AUTOBAGAZ_SHOP");
        }
    }
}
