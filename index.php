<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Тестовое задание для SkyNet</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div id="app">
      <div id="slider" class="slider">
        <div class="alert alert_error" v-if="error">{{error}}</div>
        <!-- slider Wrapper -->
        <div class="slider__wrapper" ref="wrapper" v-else>
          <!-- First Step -->
          <div class="slider__item slider__item_first">
            <div class="slider__header"><h2 class="title">Тарифы</h2></div>
            <div class="slider__body">
              <div
                class="col"
                v-for="(tariff, idx) in tariffs"
                :key="tariff.id"
              >
                <div class="card">
                  <div class="card__header">
                    <h3 class="card__title">Тариф "{{tariff.title}}"</h3>
                  </div>
                  <div
                    class="card__body slider__control slider__control_right"
                    @click="nextStep(tariff)"
                  >
                    <div class="card__speed">{{tariff.speed}} Мбит/с</div>
                    <div class="card__price">
                      {{tariff.tarifs[tariff.tarifs.length - 1].price /
                      tariff.tarifs[tariff.tarifs.length - 1].pay_period}} -
                      {{tariff.tarifs[0].price}} ₽/мес
                    </div>
                    <ul
                      class="card__options options"
                      v-if="tariff.free_options"
                    >
                      <li
                        class="options__item"
                        v-for="option in tariff.free_options"
                        :key="option.id"
                      >
                        {{option}}
                      </li>
                    </ul>
                  </div>
                  <div class="card__footer">
                    <a class="card__link" :href="tariff.link"
                      >Узнать подробнее на сайте www.sknt.ru</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Two Step -->
          <div class="slider__item slider__item_second">
            <div class="slider__header">
              <div
                class="slider__control slider__control_left"
                v-on:click="prevStep($event)"
                title="Назад"
              ></div>
              <h2 class="title" v-if="currentTariff">
                Тариф "{{currentTariff.title}}"
              </h2>
            </div>
            <div class="slider__body">
              <div
                class="col"
                v-for="(tariff, idx) in currentTariff.tarifs"
                :key="tariff.id"
              >
                <div class="card">
                  <div class="card__header">
                    <h3 class="card__title">
                      {{tariff.pay_period}} {{tariff.pay_period | declOfNum}}
                    </h3>
                  </div>
                  <div
                    class="card__body slider__control slider__control_right"
                    @click="lastStep(tariff)"
                  >
                    <div class="card__price">
                      {{tariff.price / tariff.pay_period}} ₽/мес
                    </div>
                    <ul class="card__options options">
                      <li class="options__item">
                        Разовый платёж — {{tariff.price}} ₽
                      </li>
                      <li class="options__item" v-if="idx !== 0">
                        скидка — {{currentTariff.tarifs[0].price *
                        tariff.pay_period - tariff.price}}₽
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Three Step -->
          <div class="slider__item slider__item_three">
            <div class="slider__header">
              <div
                class="slider__control slider__control_left"
                v-on:click="prevStep"
              ></div>
              <h2 class="title">Выбор тарифа</h2>
            </div>
            <div class="slider__body">
              <div class="col">
                <div class="card">
                  <div class="card__header">
                    <h3 class="card__title">
                      Тариф "{{currentTariff.title}}"
                    </h3>
                  </div>
                  <div class="card__body">
                    <div class="card__period">
                      Период оплаты — {{currentPeriod.pay_period}}
                      {{currentPeriod.pay_period | declOfNum}} <br />
                      {{currentPeriod.price / currentPeriod.pay_period}} ₽/мес
                    </div>
                    <ul class="card__options options">
                      <li class="options__item">
                        разовый платёж — {{currentPeriod.price}} ₽
                      </li>
                      <li class="options__item">
                        со счёта спишется — {{currentPeriod.price}} ₽
                      </li>
                    </ul>
                    <ul
                      class="card__options card__options_muted options"
                    >
                      <li class="options__item">
                        Вступят в силу — сегодня
                      </li>
                      <li class="options__item">
                        активен до — {{currentPeriod.pay_period | date}}
                      </li>
                    </ul>
                  </div>
                  <div class="card__footer">
                    <button class="btn btn_primary">Выбрать</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div> <!-- /.slider__wrapper -->
      </div> <!-- /.slider -->
    </div>

    <!-- Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <script src="js/main.js"></script>
  </body>
</html>
