<div class="px-4">
    <div class="card mb-4 border border-white shadow-sm">
        <div class="p-4">
            <h5>แดชบอร์ด (Dashboard)</h5>
            <div class="row mb-2">
                <div class="col">
                    <div class="container mb-2">
                        <form method="get" action="{{ route('Cus.dashboard') }}">
                        @if(Auth::user()->position == 'admin')
                        
                        <div class="row g-2">
                            <div class="col-md-4 col-lg-5 col-sm-12">
                                <select class="form-select" aria-label="Default select example" id="tablehead" name="tablehead" required>
                                    <option value="" selected>เลือกตาราง</option>
                                    <option value="1" {{ (@$head == 'ทีม A' ) ? 'selected' : '' }}>TEAM A</option>
                                    <option value="2" {{ (@$head == 'ทีม B' ) ? 'selected' : '' }}>TEAM B</option>
                                    <option value="KAI" {{ (@$head == 'ทีม C' ) ? 'selected' : '' }}>TEAM C</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-5 col-sm-12">
                                <select class="form-select" aria-label="Default select example" id="typeloan" name="typeloan" required>
                                    <option value="" selected>เลือกประเภท</option>
                                    <option value="1" {{ (@$column == 'PLM') ? 'selected' : '' }}>PLM</option>
                                    <option value="2" {{ (@$column == '50/30') ? 'selected' : '' }}>50/30</option>
                                </select>
                            </div>
                            <div class="col-md col-lg col-sm-12 d-grid gap-2">
                                <input type="submit" class="btn btn-primary" value="แสดง"/>
                            </div>
                        </div>
                        @elseif(Auth::user()->position == 'headA')
                        <div class="row">
                            <div class="col-sm">
                                <select class="form-select" aria-label="Default select example" id="tablehead" name="tablehead" required>
                                <option value="" selected>เลือกตาราง</option>
                                <option value="1">TEAM A</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <select class="form-select" aria-label="Default select example" id="typeloan" name="typeloan" required>
                                <option value="" selected>เลือกประเภท</option>
                                <option value="1">PLM</option>
                                <option value="2">50/30</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <input type="submit" class="btn btn-primary" value="แสดง"/>
                            </div>
                        </div>
                        @elseif(Auth::user()->position == 'headB')
                        <div class="row">
                            <div class="col-sm">
                            <select class="form-select" aria-label="Default select example" id="tablehead" name="tablehead" required>
                                <option value="" selected>เลือกตาราง</option>
                                <option value="2">TEAM B</option>
                            </select>
                            </div>   
                            <div class="col-sm">
                            <select class="form-select" aria-label="Default select example" id="typeloan" name="typeloan" required>
                            <option value="" selected>เลือกประเภท</option>
                            <option value="1">PLM</option>
                            <option value="2">50/30</option>
                            </select>
                            </div>
                            <div class="col-sm">
                            <input type="submit" class="btn btn-primary" value="แสดง"/>
                            </div>
                        </div>
                        @elseif(Auth::user()->position == 'user')
                        <div class="row">
                            <div class="col-6">
                                <select class="form-select" aria-label="Default select example" id="typeloan" name="typeloan" required>
                                <option value="" selected>-- เลือกประเภทสัญญา --</option>
                                <option value="1">PLM</option>
                                <option value="2">50/30</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="submit" class="btn btn-primary" value="แสดง"/>
                            </div>
                        </div>
                        @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>