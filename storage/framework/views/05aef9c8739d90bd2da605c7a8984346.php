
<?php $__env->startSection('title', 'Setup Studio Schedules'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Setup Studio Schedules</h4>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-4">
                                            <label class="form-label mb-2">Select Operating Days</label>
                                            <div class="mb-2">
                                                <div class="btn-group w-100 mb-1" role="group" aria-label="Weekday toggle button group">
                                                    <input type="checkbox" class="btn-check" id="btnMonday" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnMonday">Monday</label>

                                                    <input type="checkbox" class="btn-check" id="btnTuesday" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnTuesday">Tuesday</label>

                                                    <input type="checkbox" class="btn-check" id="btnWednesday" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnWednesday">Wednesday</label>

                                                    <input type="checkbox" class="btn-check" id="btnThursday" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnThursday">Thursday</label>

                                                    <input type="checkbox" class="btn-check" id="btnFriday" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnFriday">Friday</label>

                                                    <input type="checkbox" class="btn-check" id="btnSaturday" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnSaturday">Saturday</label>

                                                    <input type="checkbox" class="btn-check" id="btnSunday" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnSunday">Sunday</label>
                                                </div>
                                                <small class="d-block text-muted">Check which days you accept bookings</small>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-4">
                                            <label class="form-label">Select Operating Hours</label>
                                            <div class="row">
                                                <div class="col">
                                                    <label class="fs-5 mb-1 text-muted" for="openingTime">Opening Time</label>
                                                    <input type="time" class="form-control" id="openingTime" name="openingTime" required>
                                                </div>
                                                <div class="col">
                                                    <label class="fs-5 mb-1 text-muted" for="closingTime">Closing Time</label>
                                                    <input type="time" class="form-control" id="closingTime" name="closingTime" required>
                                                </div>
                                            </div>
                                        </div>

                                       <div class="row form-group">
                                            <div class="col-md-6">
                                                <label class="form-label">Booking Limits</label>
                                                <div class="mb-3">
                                                    <small class="d-block text-muted mb-1">Minimum Booking Per Day</small>
                                                    <input type="number" class="form-control" id="minBookingPerDay" value="1" name="minBookingPerDay" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label">Advance Booking</label>
                                                <div class="mb-3">
                                                    <small class="d-block text-muted mb-1">Minimum Advance Notice (Days)</small>
                                                    <input type="number" class="form-control" id="minAdvanceNotice" value="1" name="minAdvanceNotice" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.owner.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\proj\resources\views/owner/setup-schedules.blade.php ENDPATH**/ ?>