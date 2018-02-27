﻿$(document).ready(function() { // Ждём загрузки страницы

	$(".img").click(function(){	// Событие клика на маленькое изображение

		var img = $(this);	// Получаем изображение, на которое кликнули
		var src = img.attr('src'); // Достаем из этого изображения путь до картинки

		$("body").append("<div class='img__popup'>"+ //Добавляем в тело документа разметку всплывающего окна
						 "<div class='img__inner'></div>"+ // Блок, который будет служить фоном затемненным
						 "<img src="+src+" class='img__big' />"+ // Само увеличенное фото
						 "</div>");

		$(".img__popup").fadeIn(800); // Медленно выводим изображение
		$(".img__inner").click(function(){	// Событие клика на затемненный фон

			$(".img__popup").fadeOut(800);	// Медленно убираем всплывающее окно

			setTimeout(function() {	// Выставляем таймер
				$(".img__popup").remove(); // Удаляем разметку высплывающего окна
				}, 800);
		});
	});
	
});