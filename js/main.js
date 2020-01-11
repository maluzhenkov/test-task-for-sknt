//url запроса данных для fetch
const url = window.location + "tariffs.php";

//Фильтр склонений
Vue.filter("declOfNum", function(number) {
  titles = ["месяц", "месяца", "месяцев"];
  cases = [2, 0, 1, 1, 1, 2];
  return titles[
    number % 100 > 4 && number % 100 < 20
      ? 2
      : cases[number % 10 < 5 ? number % 10 : 5]
  ];
});

//Фильтр даты
Vue.filter("date", function(number) {
  const D = new Date();
  D.setMonth(D.getMonth() + parseInt(number));
  const options = {
    day: "2-digit",
    month: "2-digit",
    year: "numeric"
  };
  return D.toLocaleString("ru-RU", options);
});

//Инициализация Vue
new Vue({
  el: "#app",
  data: {
    tariffs: [], //тарифы с backend
    currentTariff: [], //текущий выбранный тариф
    currentPeriod: [], //текущий выбранный период

    positionLeftItem: 0, // позиция левого активного элемента
    transform: 0, // значение транфсофрмации .slider_wrapper
    wrapperWidth: 0, // ширина обёртки
    itemWidth: 0, // ширина одного элемента
    items: [], //слайды
    position: null,
    error: ""
  },
  computed: {
    step() {
      return (this.itemWidth / this.wrapperWidth) * 100;
    }
  },
  methods: {
    prevStep() {
      this.transformItem("left");
    },
    nextStep(tariffs) {
      this.currentTariff = tariffs;

      this.transformItem("right");
    },
    lastStep(period) {
      this.currentPeriod = period;

      this.transformItem("right");
    },

    transformItem(direction) {
      if (direction === "right") {
        if (
          this.positionLeftItem + this.wrapperWidth / this.itemWidth - 1 >=
          this.position.getMax
        ) {
          return;
        }
        this.positionLeftItem++;
        this.transform -= this.step;
      }
      if (direction === "left") {
        if (this.positionLeftItem <= this.position.getMin) {
          return;
        }
        this.positionLeftItem--;
        this.transform += this.step;
      }
      this.$refs.wrapper.style.transform =
        "translateX(" + this.transform + "%)";
      window.scrollTo(pageXOffset, 0);
    }
  },

  async mounted() {
    try {
      const respons = await fetch(url);
      const json = await respons.json();
      this.tariffs = json.tarifs;
      this.error = "";
    } catch (error) {
      this.error =
        "Ошибка: неудалось получить данные с сервера, проверьте корректность запроса!";
      console.error(error);
    }

    this.wrapperWidth = parseFloat(getComputedStyle(this.$refs.wrapper).width);
    const sliderItems = this.$refs.wrapper.querySelectorAll(".slider__item"); // элементы (.slider__item)
    this.itemWidth = parseFloat(getComputedStyle(sliderItems[0]).width);
    // наполнение массива items
    const items = [];
    sliderItems.forEach(function(item, index) {
      items.push({ item, position: index, transform: 0 });
    });
    this.position = {
      getMin: 0,
      getMax: items.length - 1
    };
    this.items = items;
  }
});
