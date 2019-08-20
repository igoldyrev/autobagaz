﻿// <auto-generated />
using System;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Infrastructure;
using Microsoft.EntityFrameworkCore.Migrations;
using Microsoft.EntityFrameworkCore.Storage.ValueConversion;
using autobagaz;

namespace autobagaz.Migrations
{
    [DbContext(typeof(AutobagazContext))]
    [Migration("20190820073454_ShopPerson")]
    partial class ShopPerson
    {
        protected override void BuildTargetModel(ModelBuilder modelBuilder)
        {
#pragma warning disable 612, 618
            modelBuilder
                .HasAnnotation("ProductVersion", "2.2.6-servicing-10079")
                .HasAnnotation("Relational:MaxIdentifierLength", 64);

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_KOMISSION_GOOD", b =>
                {
                    b.Property<int>("AUTOBAGAZ_KOMISSION_GOOD_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("AUTOBAGAZ_KOMISSION_DATE")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_NAME")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_PHOTO1");

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_PHOTO2");

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_PHOTO3");

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_PHOTO4");

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_PHOTO5");

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_PRICE");

                    b.Property<string>("AUTOBAGAZ_KOMISSION_GOOD_TYPE");

                    b.Property<int>("KOMISSION_STATUS_ID");

                    b.Property<int>("KOMISSION_USER_ID");

                    b.HasKey("AUTOBAGAZ_KOMISSION_GOOD_ID");

                    b.HasIndex("KOMISSION_STATUS_ID");

                    b.HasIndex("KOMISSION_USER_ID");

                    b.ToTable("AUTOBAGAZ_KOMISSION_GOODS");
                });

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_ROLE", b =>
                {
                    b.Property<int>("AUTOBAGAZ_ROLE_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("AUTOBAGAZ_ROLE_DESCRIPTION")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_ROLE_NAME")
                        .IsRequired();

                    b.HasKey("AUTOBAGAZ_ROLE_ID");

                    b.ToTable("AUTOBAGAZ_ROLE");
                });

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_SPECIAL_OFFER", b =>
                {
                    b.Property<int>("AUTOBAGAZ_SPECIAL_OFFER_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("AUTOBAGAZ_SPECIAL_OFFER_DATE")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_SPECIAL_OFFER_NAME")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_SPECIAL_OFFER_OLDPRICE");

                    b.Property<string>("AUTOBAGAZ_SPECIAL_OFFER_PHOTO");

                    b.Property<string>("AUTOBAGAZ_SPECIAL_OFFER_PRICE");

                    b.Property<int>("SPECIAL_OFFER_STATUS_ID");

                    b.Property<int>("SPECIAL_OFFER_USER_ID");

                    b.HasKey("AUTOBAGAZ_SPECIAL_OFFER_ID");

                    b.HasIndex("SPECIAL_OFFER_STATUS_ID");

                    b.HasIndex("SPECIAL_OFFER_USER_ID");

                    b.ToTable("AUTOBAGAZ_SPECIAL_GOODS");
                });

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_STATUS", b =>
                {
                    b.Property<int>("AUTOBAGAZ_STATUS_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("AUTOBAGAZ_STATUS_CODE")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_STATUS_NAME")
                        .IsRequired();

                    b.HasKey("AUTOBAGAZ_STATUS_ID");

                    b.ToTable("AUTOBAGAZ_STATUS");
                });

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_USER", b =>
                {
                    b.Property<int>("AUTOBAGAZ_USER_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("AUTOBAGAZ_USER_DATE")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_USER_EMAIL")
                        .IsRequired();

                    b.Property<bool>("AUTOBAGAZ_USER_IS_ACTIVE");

                    b.Property<string>("AUTOBAGAZ_USER_NAME")
                        .IsRequired();

                    b.Property<string>("AUTOBAGAZ_USER_PASSWORD")
                        .IsRequired();

                    b.Property<int>("AUTOBAGAZ_USER_ROLE_ID");

                    b.Property<int>("AUTOBAGAZ_USER_STATUS_ID");

                    b.HasKey("AUTOBAGAZ_USER_ID");

                    b.HasIndex("AUTOBAGAZ_USER_ROLE_ID");

                    b.HasIndex("AUTOBAGAZ_USER_STATUS_ID");

                    b.ToTable("AUTOBAGAZ_USERS");
                });

            modelBuilder.Entity("autobagaz.Autobagazhnik", b =>
                {
                    b.Property<int>("AUTOBAGAZHIK_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<DateTime>("AUTOBAGAZHIK_DATE");

                    b.Property<string>("AUTOBAGAZHIK_DESCRIPTION");

                    b.Property<string>("AUTOBAGAZHIK_FILE_NAME");

                    b.Property<string>("AUTOBAGAZHIK_FILE_PATH");

                    b.Property<string>("AUTOBAGAZHIK_NAME")
                        .IsRequired();

                    b.Property<int?>("AUTOBAGAZHIK_STATUS");

                    b.Property<int?>("AUTOBAGAZHIK_USER");

                    b.HasKey("AUTOBAGAZHIK_ID");

                    b.HasIndex("AUTOBAGAZHIK_STATUS");

                    b.HasIndex("AUTOBAGAZHIK_USER");

                    b.ToTable("AUTOBAGAZHIK");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikReelings", b =>
                {
                    b.Property<int>("AUTOBAGAZHIK_REELINGS_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<DateTime>("AUTOBAGAZHIK_REELINGS_DATE");

                    b.Property<string>("AUTOBAGAZHIK_REELINGS_DESCRIPTION");

                    b.Property<string>("AUTOBAGAZHIK_REELINGS_FILE_NAME");

                    b.Property<string>("AUTOBAGAZHIK_REELINGS_FILE_PATH");

                    b.Property<string>("AUTOBAGAZHIK_REELINGS_NAME")
                        .IsRequired();

                    b.Property<int?>("REELINGS_STATUS");

                    b.Property<int?>("REELINGS_USER");

                    b.HasKey("AUTOBAGAZHIK_REELINGS_ID");

                    b.HasIndex("REELINGS_STATUS");

                    b.HasIndex("REELINGS_USER");

                    b.ToTable("AUTOBAGAZHIK_REELINGS");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikShtatnye", b =>
                {
                    b.Property<int>("AUTOBAGAZHIK_SHTATNYE_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<DateTime>("AUTOBAGAZHIK_SHTATNYE_DATE");

                    b.Property<string>("AUTOBAGAZHIK_SHTATNYE_DESCRIPTION");

                    b.Property<string>("AUTOBAGAZHIK_SHTATNYE_FILE_NAME");

                    b.Property<string>("AUTOBAGAZHIK_SHTATNYE_FILE_PATH");

                    b.Property<string>("AUTOBAGAZHIK_SHTATNYE_NAME")
                        .IsRequired();

                    b.Property<int?>("SHTATNYE_STATUS");

                    b.Property<int?>("SHTATNYE_USER");

                    b.HasKey("AUTOBAGAZHIK_SHTATNYE_ID");

                    b.HasIndex("SHTATNYE_STATUS");

                    b.HasIndex("SHTATNYE_USER");

                    b.ToTable("AUTOBAGAZHIK_SHTATNYE");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikSmooth", b =>
                {
                    b.Property<int>("AUTOBAGAZHIK_SMOOTH_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<DateTime>("AUTOBAGAZHIK_SMOOTH_DATE");

                    b.Property<string>("AUTOBAGAZHIK_SMOOTH_DESCRIPTION");

                    b.Property<string>("AUTOBAGAZHIK_SMOOTH_FILE_NAME");

                    b.Property<string>("AUTOBAGAZHIK_SMOOTH_FILE_PATH");

                    b.Property<string>("AUTOBAGAZHIK_SMOOTH_NAME")
                        .IsRequired();

                    b.Property<int?>("SMOOTH_STATUS");

                    b.Property<int?>("SMOOTH_USER");

                    b.HasKey("AUTOBAGAZHIK_SMOOTH_ID");

                    b.HasIndex("SMOOTH_STATUS");

                    b.HasIndex("SMOOTH_USER");

                    b.ToTable("AUTOBAGAZHIK_SMOOTH");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikVodostok", b =>
                {
                    b.Property<int>("AUTOBAGAZHIK_VODOSTOK_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<DateTime>("AUTOBAGAZHIK_VODOSTOK_DATE");

                    b.Property<string>("AUTOBAGAZHIK_VODOSTOK_DESCRIPTION");

                    b.Property<string>("AUTOBAGAZHIK_VODOSTOK_FILE_NAME");

                    b.Property<string>("AUTOBAGAZHIK_VODOSTOK_FILE_PATH");

                    b.Property<string>("AUTOBAGAZHIK_VODOSTOK_NAME")
                        .IsRequired();

                    b.Property<int?>("VODOSTOK_STATUS");

                    b.Property<int?>("VODOSTOK_USER");

                    b.HasKey("AUTOBAGAZHIK_VODOSTOK_ID");

                    b.HasIndex("VODOSTOK_STATUS");

                    b.HasIndex("VODOSTOK_USER");

                    b.ToTable("AUTOBAGAZHIK_VODOSTOK");
                });

            modelBuilder.Entity("autobagaz.City", b =>
                {
                    b.Property<int>("AUTOBAGAZ_CITY_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("AUTOBAGAZ_CITY_NAME")
                        .IsRequired();

                    b.HasKey("AUTOBAGAZ_CITY_ID");

                    b.ToTable("AUTOBAGAZ_CITY");
                });

            modelBuilder.Entity("autobagaz.Shop", b =>
                {
                    b.Property<int>("AUTOBAGAZ_SHOP_ID")
                        .ValueGeneratedOnAdd();

                    b.Property<int>("AUTOBAGAZ_CITY_ID");

                    b.Property<string>("AUTOBAGAZ_SHOP_MAP");

                    b.Property<string>("AUTOBAGAZ_SHOP_NAME");

                    b.Property<string>("AUTOBAGAZ_SHOP_PERSON_NAME");

                    b.Property<string>("AUTOBAGAZ_SHOP_PERSON_PHONE");

                    b.Property<string>("AUTOBAGAZ_SHOP_PHONE");

                    b.Property<string>("AUTOBAGAZ_SHOP_PHOTO_URL1");

                    b.Property<string>("AUTOBAGAZ_SHOP_PHOTO_URL2");

                    b.Property<string>("AUTOBAGAZ_SHOP_PHOTO_URL3");

                    b.Property<string>("AUTOBAGAZ_SHOP_PHOTO_URL4");

                    b.HasKey("AUTOBAGAZ_SHOP_ID");

                    b.HasIndex("AUTOBAGAZ_CITY_ID");

                    b.ToTable("AUTOBAGAZ_SHOP");
                });

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_KOMISSION_GOOD", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZ_STATUS")
                        .WithMany()
                        .HasForeignKey("KOMISSION_STATUS_ID")
                        .OnDelete(DeleteBehavior.Cascade);

                    b.HasOne("autobagaz.AUTOBAGAZ_USER", "AUTOBAGAZ_USER")
                        .WithMany()
                        .HasForeignKey("KOMISSION_USER_ID")
                        .OnDelete(DeleteBehavior.Cascade);
                });

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_SPECIAL_OFFER", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZ_STATUS")
                        .WithMany()
                        .HasForeignKey("SPECIAL_OFFER_STATUS_ID")
                        .OnDelete(DeleteBehavior.Cascade);

                    b.HasOne("autobagaz.AUTOBAGAZ_USER", "AUTOBAGAZ_USER")
                        .WithMany()
                        .HasForeignKey("SPECIAL_OFFER_USER_ID")
                        .OnDelete(DeleteBehavior.Cascade);
                });

            modelBuilder.Entity("autobagaz.AUTOBAGAZ_USER", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_ROLE", "AUTOBAGAZ_ROLE")
                        .WithMany()
                        .HasForeignKey("AUTOBAGAZ_USER_ROLE_ID")
                        .OnDelete(DeleteBehavior.Cascade);

                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZ_STATUS")
                        .WithMany()
                        .HasForeignKey("AUTOBAGAZ_USER_STATUS_ID")
                        .OnDelete(DeleteBehavior.Cascade);
                });

            modelBuilder.Entity("autobagaz.Autobagazhnik", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZHIK_STATUS_ID")
                        .WithMany()
                        .HasForeignKey("AUTOBAGAZHIK_STATUS");

                    b.HasOne("autobagaz.AUTOBAGAZ_USER", "AUTOBAGAZHIK_USER_ID")
                        .WithMany()
                        .HasForeignKey("AUTOBAGAZHIK_USER");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikReelings", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZHIK_REELINGS_STATUS_ID")
                        .WithMany()
                        .HasForeignKey("REELINGS_STATUS");

                    b.HasOne("autobagaz.AUTOBAGAZ_USER", "AUTOBAGAZHIK_REELINGS_USER_ID")
                        .WithMany()
                        .HasForeignKey("REELINGS_USER");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikShtatnye", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZHIK_SHTATNYE_STATUS_ID")
                        .WithMany()
                        .HasForeignKey("SHTATNYE_STATUS");

                    b.HasOne("autobagaz.AUTOBAGAZ_USER", "AUTOBAGAZHIK_SHTATNYE_USER_ID")
                        .WithMany()
                        .HasForeignKey("SHTATNYE_USER");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikSmooth", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZHIK_SMOOTH_STATUS_ID")
                        .WithMany()
                        .HasForeignKey("SMOOTH_STATUS");

                    b.HasOne("autobagaz.AUTOBAGAZ_USER", "AUTOBAGAZHIK_SMOOTH_USER_ID")
                        .WithMany()
                        .HasForeignKey("SMOOTH_USER");
                });

            modelBuilder.Entity("autobagaz.AutobagazhnikVodostok", b =>
                {
                    b.HasOne("autobagaz.AUTOBAGAZ_STATUS", "AUTOBAGAZHIK_VODOSTOK_STATUS_ID")
                        .WithMany()
                        .HasForeignKey("VODOSTOK_STATUS");

                    b.HasOne("autobagaz.AUTOBAGAZ_USER", "AUTOBAGAZHIK_VODOSTOK_USER_ID")
                        .WithMany()
                        .HasForeignKey("VODOSTOK_USER");
                });

            modelBuilder.Entity("autobagaz.Shop", b =>
                {
                    b.HasOne("autobagaz.City", "City")
                        .WithMany("Shops")
                        .HasForeignKey("AUTOBAGAZ_CITY_ID")
                        .OnDelete(DeleteBehavior.Cascade);
                });
#pragma warning restore 612, 618
        }
    }
}
