<div id="" class="row d-md-flex justify-content-center   @isset($result['mono']) d-none @endisset"
    style="background: linear-gradient(to right bottom, rgb(3, 76, 147), rgb(236, 117, 0));">
    <div class="bg-white col-sm-7 p-3 shadow m-3">
        <h1 style="text-align: center">Recherche médicament</h1>
        <div class="input-group mb-3 no-gutters">
            <div class="input-group-prepend col-xs-12 col-sm-3 ">
                <select id="type_search" class="custom-select ">
                    <option value="meds" selected>Médicament</option>
                    <option value="sac">Substance Active</option>
                    {{-- <option value="atc">Classe ATC</option>
                    --}}
                </select>
            </div>
            <input id="med_search" style='min-width:0px' class="form-control"
                placeholder="Entrer le nom commercial d'un médicament">
            {{-- <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div> --}}
        </div>

        <ul class="nav nav-pills justify-content-center">
            <div class="sport-item">
                <a href="{{ route('medicaments.noms-commerciale') }}" style="text-decoration:none">
                    <div class="img-wrapper">
                        <img class="js-img-lazy js-img-lazy-loaded" src="{{ asset('bddm/images/icon-3.png') }}" alt=""
                            style="width:80px;height:80px" data-lazy-fade="1000">
                    </div>
                    <div class="sports-label">MEDICAMENTS</div>
                </a>
            </div>
            <div class="sport-item">
                <a href="{{ route('medicaments.substances') }}" style="text-decoration:none">
                    <div class="img-wrapper">
                        <img class="js-img-lazy js-img-lazy-loaded" src="{{ asset('bddm/images/icon-1.png') }}" alt=""
                            style="width:80px;height:80px" data-lazy-fade="1000">
                    </div>
                    <div class="sports-label">SUBSTANCES</div>
                </a>
            </div>
            {{-- <div class="sport-item">
                <a href="{{ route('medicaments.classes') }}" style="text-decoration:none">
                    <div class="img-wrapper">
                        <img class="js-img-lazy js-img-lazy-loaded" src="{{ asset('bddm/images/icon-2.png') }}" alt=""
                            style="width:80px;height:80px" data-lazy-fade="1000">
                    </div>
                    <div class="sports-label">CLASSES ATC</div>
                </a>
            </div> --}}
            <div class="sport-item">
                <a href="{{ route('medicaments.indications') }}" style="text-decoration:none">
                    <div class="img-wrapper">
                        <img class="js-img-lazy js-img-lazy-loaded" src="{{ asset('bddm/images/icon-4.png') }}" alt=""
                            style="width:80px;height:80px" data-lazy-fade="1000">
                    </div>
                    <div class="sports-label">INDICATIONS</div>
                </a>
            </div>
        </ul>
    </div>
</div>
