using System;
using Microsoft.EntityFrameworkCore.Migrations;

namespace autobagaz.Migrations
{
    public partial class CoreTables : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_ROLE",
                columns: table => new
                {
                    AUTOBAGAZ_ROLE_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZ_ROLE_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZ_ROLE_DESCRIPTION = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_ROLE", x => x.AUTOBAGAZ_ROLE_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_STATUS",
                columns: table => new
                {
                    AUTOBAGAZ_STATUS_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZ_STATUS_CODE = table.Column<string>(nullable: false),
                    AUTOBAGAZ_STATUS_NAME = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_STATUS", x => x.AUTOBAGAZ_STATUS_ID);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZ_USERS",
                columns: table => new
                {
                    AUTOBAGAZ_USER_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZ_USER_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZ_USER_PASSWORD = table.Column<string>(nullable: false),
                    AUTOBAGAZ_USER_IS_ACTIVE = table.Column<short>(nullable: false),
                    AUTOBAGAZ_USER_ROLE_ID = table.Column<int>(nullable: false),
                    AUTOBAGAZ_USER_DATE = table.Column<DateTime>(nullable: false),
                    AUTOBAGAZ_USER_STATUS = table.Column<int>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZ_USERS", x => x.AUTOBAGAZ_USER_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZ_USERS_AUTOBAGAZ_ROLE_AUTOBAGAZ_USER_ROLE_ID",
                        column: x => x.AUTOBAGAZ_USER_ROLE_ID,
                        principalTable: "AUTOBAGAZ_ROLE",
                        principalColumn: "AUTOBAGAZ_ROLE_ID",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZ_USERS_AUTOBAGAZ_STATUS_AUTOBAGAZ_USER_STATUS",
                        column: x => x.AUTOBAGAZ_USER_STATUS,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK",
                columns: table => new
                {
                    AUTOBAGAZHIK_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZHIK_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_DESCRIPTION = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_DATE = table.Column<DateTime>(nullable: false),
                    AUTOBAGAZHIK_STATUS = table.Column<int>(nullable: true),
                    AUTOBAGAZHIK_USER = table.Column<int>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK", x => x.AUTOBAGAZHIK_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_AUTOBAGAZ_STATUS_AUTOBAGAZHIK_STATUS",
                        column: x => x.AUTOBAGAZHIK_STATUS,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Restrict);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_AUTOBAGAZ_USERS_AUTOBAGAZHIK_USER",
                        column: x => x.AUTOBAGAZHIK_USER,
                        principalTable: "AUTOBAGAZ_USERS",
                        principalColumn: "AUTOBAGAZ_USER_ID",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_REELINGS",
                columns: table => new
                {
                    AUTOBAGAZHIK_REELINGS_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_REELINGS_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZHIK_REELINGS_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_REELINGS_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_REELINGS_DESCRIPTION = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_REELINGS_DATE = table.Column<DateTime>(nullable: false),
                    REELINGS_STATUS = table.Column<int>(nullable: true),
                    REELINGS_USER = table.Column<int>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_REELINGS", x => x.AUTOBAGAZHIK_REELINGS_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_REELINGS_AUTOBAGAZ_STATUS_REELINGS_STATUS",
                        column: x => x.REELINGS_STATUS,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Restrict);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_REELINGS_AUTOBAGAZ_USERS_REELINGS_USER",
                        column: x => x.REELINGS_USER,
                        principalTable: "AUTOBAGAZ_USERS",
                        principalColumn: "AUTOBAGAZ_USER_ID",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_SHTATNYE",
                columns: table => new
                {
                    AUTOBAGAZHIK_SHTATNYE_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_SHTATNYE_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZHIK_SHTATNYE_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SHTATNYE_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SHTATNYE_DESCRIPTION = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SHTATNYE_DATE = table.Column<DateTime>(nullable: false),
                    SHTATNYE_STATUS = table.Column<int>(nullable: true),
                    SHTATNYE_USER = table.Column<int>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_SHTATNYE", x => x.AUTOBAGAZHIK_SHTATNYE_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_SHTATNYE_AUTOBAGAZ_STATUS_SHTATNYE_STATUS",
                        column: x => x.SHTATNYE_STATUS,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Restrict);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_SHTATNYE_AUTOBAGAZ_USERS_SHTATNYE_USER",
                        column: x => x.SHTATNYE_USER,
                        principalTable: "AUTOBAGAZ_USERS",
                        principalColumn: "AUTOBAGAZ_USER_ID",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_SMOOTH",
                columns: table => new
                {
                    AUTOBAGAZHIK_SMOOTH_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_SMOOTH_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZHIK_SMOOTH_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SMOOTH_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SMOOTH_DESCRIPTION = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_SMOOTH_DATE = table.Column<DateTime>(nullable: false),
                    SMOOTH_STATUS = table.Column<int>(nullable: true),
                    SMOOTH_USER = table.Column<int>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_SMOOTH", x => x.AUTOBAGAZHIK_SMOOTH_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_SMOOTH_AUTOBAGAZ_STATUS_SMOOTH_STATUS",
                        column: x => x.SMOOTH_STATUS,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Restrict);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_SMOOTH_AUTOBAGAZ_USERS_SMOOTH_USER",
                        column: x => x.SMOOTH_USER,
                        principalTable: "AUTOBAGAZ_USERS",
                        principalColumn: "AUTOBAGAZ_USER_ID",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateTable(
                name: "AUTOBAGAZHIK_VODOSTOK",
                columns: table => new
                {
                    AUTOBAGAZHIK_VODOSTOK_ID = table.Column<int>(nullable: false)
                        .Annotation("MySQL:AutoIncrement", true),
                    AUTOBAGAZHIK_VODOSTOK_NAME = table.Column<string>(nullable: false),
                    AUTOBAGAZHIK_VODOSTOK_FILE_NAME = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_VODOSTOK_FILE_PATH = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_VODOSTOK_DESCRIPTION = table.Column<string>(nullable: true),
                    AUTOBAGAZHIK_VODOSTOK_DATE = table.Column<DateTime>(nullable: false),
                    VODOSTOK_STATUS = table.Column<int>(nullable: true),
                    VODOSTOK_USER = table.Column<int>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AUTOBAGAZHIK_VODOSTOK", x => x.AUTOBAGAZHIK_VODOSTOK_ID);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_VODOSTOK_AUTOBAGAZ_STATUS_VODOSTOK_STATUS",
                        column: x => x.VODOSTOK_STATUS,
                        principalTable: "AUTOBAGAZ_STATUS",
                        principalColumn: "AUTOBAGAZ_STATUS_ID",
                        onDelete: ReferentialAction.Restrict);
                    table.ForeignKey(
                        name: "FK_AUTOBAGAZHIK_VODOSTOK_AUTOBAGAZ_USERS_VODOSTOK_USER",
                        column: x => x.VODOSTOK_USER,
                        principalTable: "AUTOBAGAZ_USERS",
                        principalColumn: "AUTOBAGAZ_USER_ID",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_USERS_AUTOBAGAZ_USER_ROLE_ID",
                table: "AUTOBAGAZ_USERS",
                column: "AUTOBAGAZ_USER_ROLE_ID");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZ_USERS_AUTOBAGAZ_USER_STATUS",
                table: "AUTOBAGAZ_USERS",
                column: "AUTOBAGAZ_USER_STATUS");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_AUTOBAGAZHIK_STATUS",
                table: "AUTOBAGAZHIK",
                column: "AUTOBAGAZHIK_STATUS");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_AUTOBAGAZHIK_USER",
                table: "AUTOBAGAZHIK",
                column: "AUTOBAGAZHIK_USER");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_REELINGS_REELINGS_STATUS",
                table: "AUTOBAGAZHIK_REELINGS",
                column: "REELINGS_STATUS");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_REELINGS_REELINGS_USER",
                table: "AUTOBAGAZHIK_REELINGS",
                column: "REELINGS_USER");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_SHTATNYE_SHTATNYE_STATUS",
                table: "AUTOBAGAZHIK_SHTATNYE",
                column: "SHTATNYE_STATUS");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_SHTATNYE_SHTATNYE_USER",
                table: "AUTOBAGAZHIK_SHTATNYE",
                column: "SHTATNYE_USER");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_SMOOTH_SMOOTH_STATUS",
                table: "AUTOBAGAZHIK_SMOOTH",
                column: "SMOOTH_STATUS");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_SMOOTH_SMOOTH_USER",
                table: "AUTOBAGAZHIK_SMOOTH",
                column: "SMOOTH_USER");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_VODOSTOK_VODOSTOK_STATUS",
                table: "AUTOBAGAZHIK_VODOSTOK",
                column: "VODOSTOK_STATUS");

            migrationBuilder.CreateIndex(
                name: "IX_AUTOBAGAZHIK_VODOSTOK_VODOSTOK_USER",
                table: "AUTOBAGAZHIK_VODOSTOK",
                column: "VODOSTOK_USER");
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

            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_USERS");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_ROLE");

            migrationBuilder.DropTable(
                name: "AUTOBAGAZ_STATUS");
        }
    }
}
