<div class="px-4">
    <div class="card mb-4 border border-white shadow-sm">
        <div class="p-4">
            <h5>แดชบอร์ด (Dashboard) {{@$head}}</h5>
            <div class="row mb-2">
                <div class="col">
                    <div class="container mb-2">
                        <form method="get" action="{{ route('Cus.dashboard') }}">                       
                        <div class="row g-2">
                            <div class="col-md-4 col-lg-5 col-sm-12">
                                <select class="form-select" aria-label="Default select example" id="tablehead" name="tablehead" required>
                                    <option value="" selected>เลือกตาราง</option>
                                    <option value="1" {{ (@$head == '1' ) ? 'selected' : '' }}>TEAM A</option>
                                    <option value="2" {{ (@$head == '2' ) ? 'selected' : '' }}>TEAM B</option>
                                    <option value="3" {{ (@$head == '3' ) ? 'selected' : '' }}>TEAM C</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-5 col-sm-12">
                                <select class="form-select" aria-label="Default select example" id="typeloan" name="typeloan" required>
                                    <option value="" selected>เลือกประเภท</option>
                                    <option value="1" {{ (@$column == '1') ? 'selected' : '' }}>PLM</option>
                                    <option value="2" {{ (@$column == '2') ? 'selected' : '' }}>50/30</option>
                                </select>
                            </div>
                            <div class="col-md col-lg col-sm-12 d-grid gap-2">
                                <input type="submit" class="btn btn-primary" value="แสดง"/>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>