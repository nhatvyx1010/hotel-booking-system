@extends('hotel.hotel_dashboard')
@section('hotel')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container">
        <div class="main-body">
            <div class="row">
    <div class="card">
        <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Quản lý Phòng</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Số Phòng</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                            <div class="col-xl-12 mx-auto">
						
						<div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Cập nhật Phòng</h5>
			<form class="row g-3" action="{{ route('hotel.update.room', $editData->id) }}" method="post" enctype="multipart/form-data">
				@csrf

                <div class="col-md-4">
                    <label for="input1" class="form-label">Tên Loại Phòng </label>
                    <input type="text" name="roomtype_name" class="form-control" id="input1" value="{{ $editData->type->name }}" >
                </div>
				<div class="col-md-4">
					<label for="input2" class="form-label">Tổng số Người lớn</label>
					<input type="text" name="total_adult" class="form-control" id="input2" value="{{ $editData->total_adult }}">
				</div>

				<div class="col-md-4">
					<label for="input2" class="form-label">Tổng số Trẻ em</label>
					<input type="text" name="total_child" class="form-control" id="input2" value="{{ $editData->total_child }}">
				</div>

				<div class="col-md-6">
					<label for="input3" class="form-label">Ảnh Chính</label>
					<input type="file" name="image" class="form-control" id="image">
					<img id="showImage" src="{{ (!empty($editData->image)) ? url('upload/roomimg/'.$editData->image) : url('upload/no_image.jpg') }}" alt="Admin" class="bg-primary" width="60">
				</div>
				<div class="col-md-6">
					<label for="input4" class="form-label">Ảnh Thư Viện</label>
					<input type="file" name="multi_img[]" class="form-control" multiple id="multiImg" accept="image/jpeg, image/jpg, image/gif, image/png">
					@foreach ($multiimgs as $item)
					<img src="{{ (!empty($item->multi_img)) ? url('upload/roomimg/multi_img/'.$item->multi_img) : url('upload/no_image.jpg') }}" alt="Admin" class="bg-primary" width="60">
                        <a href="{{ route('hotel.multi.image.delete', $item->id) }}"><i class="lni lni-close"></i></a>
                    @endforeach
                    <div class="row" id="preview_img"></div>
				</div>

				<div class="col-md-3">
					<label for="input1" class="form-label">Giá Phòng</label>
					<input type="text" name="price" class="form-control" id="input1" value="{{ $editData->price}}" >
				</div>
				<div class="col-md-3">
					<label for="input2" class="form-label">Kích thước</label>
					<input type="text" name="size" class="form-control" id="input2" value="{{ $editData->size }}">
				</div>
				<div class="col-md-3">
					<label for="input2" class="form-label">Giảm Giá ( % )</label>
					<input type="text" name="discount" class="form-control" id="input2" value="{{ $editData->discount }}">
				</div>

				<div class="col-md-3">
					<label for="input2" class="form-label">Sức chứa</label>
					<input type="text" name="room_capacity" class="form-control" id="input2" value="{{ $editData->room_capacity }}">
				</div>

				<div class="col-md-6">
					<label for="input7" class="form-label">View</label>
					<select name="view" id="input7" class="form-select">
						<option selected="">Choose...</option>
						<option value="Sea View" {{$editData->view == 'Sea View'?'selected':''}}>View Biển</option>
						<option value="Mountain View" {{$editData->view == 'Mountain View'?'selected':''}}>View Núi</option>
						<option value="City View" {{$editData->view == 'City View'?'selected':''}}>View Thành phố</option>
						<option value="Garden View" {{$editData->view == 'Garden View'?'selected':''}}>View Vườn</option>
						<option value="River View" {{$editData->view == 'River View'?'selected':''}}>View Sông</option>
						<option value="Ocean View" {{$editData->view == 'Ocean View'?'selected':''}}>View Đại dương</option>
						<option value="Forest View" {{$editData->view == 'Forest View'?'selected':''}}>View Rừng</option>
						<option value="Park View" {{$editData->view == 'Park View'?'selected':''}}>View Công viên</option>
						<option value="No View" {{$editData->view == 'No View'?'selected':''}}>No View</option>
					</select>
				</div>

				<div class="col-md-6">
					<label for="input7" class="form-label">Kiểu Giường</label>
					<select name="bed_style" id="input7" class="form-select">
						<option selected="">Chọn...</option>
						<option value="Single Bed" {{$editData->bed_style == 'Single Bed'?'selected':''}}>Giường Đơn</option>
						<option value="Twin Bed" {{$editData->bed_style == 'Twin Bed'?'selected':''}}>Giường Đôi Nhỏ</option>
						<option value="Double Bed" {{$editData->bed_style == 'Double Bed'?'selected':''}}>Giường Đôi</option>
						<option value="Queen Bed" {{$editData->bed_style == 'Queen Bed'?'selected':''}}>Giường Queen</option>
						<option value="King Bed" {{$editData->bed_style == 'King Bed'?'selected':''}}>Giường King</option>
					</select>
				</div>

				<div class="col-md-12">
					<label for="input11" class="form-label">Mô tả ngắn</label>
					<textarea name="short_desc" class="form-control" id="input11" placeholder="Address ..." rows="3">{{ $editData->short_desc }}</textarea>
				</div>

				<div class="col-md-12">
					<label for="input11" class="form-label">Mô tả chi tiết</label>
					<textarea name="description" class="form-control" id="myeditorinstance">{!! $editData->description !!}</textarea>
				</div>

				<div class="row mt-2">
<div id="facility_container">
    @forelse ($basic_facility as $item)
        <div class="basic_facility_row row mb-3">
            <div class="col-md-8">
                <label for="facility_name" class="form-label">Tiện nghi trong phòng</label>
                <select name="facility_name[]" class="form-control facility-select">
                    <option value="">Chọn tiện nghi</option>
                    <option value="Complimentary Breakfast" {{ $item->facility_name == 'Complimentary Breakfast' ? 'selected' : '' }}>Bữa sáng miễn phí</option>
                    <option value="32/42 inch LED TV" {{ $item->facility_name == '32/42 inch LED TV' ? 'selected' : '' }}>TV</option>
                    <option value="Smoke alarms" {{ $item->facility_name == 'Smoke alarms' ? 'selected' : '' }}>Báo cháy</option>
                    <option value="Minibar" {{ $item->facility_name == 'Minibar' ? 'selected' : '' }}>Tủ lạnh mini</option>
                    <option value="Work Desk" {{ $item->facility_name == 'Work Desk' ? 'selected' : '' }}>Bàn làm việc</option>
                    <option value="Free Wi-Fi" {{ $item->facility_name == 'Free Wi-Fi' ? 'selected' : '' }}>Wi-Fi miễn phí</option>
                    <option value="Safety box" {{ $item->facility_name == 'Safety box' ? 'selected' : '' }}>Két an toàn</option>
                    <option value="Rain Shower" {{ $item->facility_name == 'Rain Shower' ? 'selected' : '' }}>Vòi sen mưa</option>
                    <option value="Slippers" {{ $item->facility_name == 'Slippers' ? 'selected' : '' }}>Dép đi trong nhà</option>
                    <option value="Hair dryer" {{ $item->facility_name == 'Hair dryer' ? 'selected' : '' }}>Máy sấy tóc</option>
                    <option value="Wake-up service" {{ $item->facility_name == 'Wake-up service' ? 'selected' : '' }}>Dịch vụ báo thức</option>
                    <option value="Laundry & Dry Cleaning" {{ $item->facility_name == 'Laundry & Dry Cleaning' ? 'selected' : '' }}>Giặt ủi</option>
                    <option value="Electronic door lock" {{ $item->facility_name == 'Electronic door lock' ? 'selected' : '' }}>Khóa cửa điện tử</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="button" class="btn btn-success add-facility me-2"><i class="lni lni-circle-plus"></i></button>
                <button type="button" class="btn btn-danger remove-facility"><i class="lni lni-circle-minus"></i></button>
            </div>
        </div>
    @empty
        {{-- If no facilities, load 1 blank row --}}
        <div class="basic_facility_row row mb-3">
            <div class="col-md-8">
                <label for="facility_name" class="form-label">Tiện nghi trong phòng</label>
                <select name="facility_name[]" class="form-control facility-select">
                    <option value="">Chọn tiện nghi</option>
                    <option value="Complimentary Breakfast">Bữa sáng miễn phí</option>
                    <option value="32/42 inch LED TV">TV</option>
                    <option value="Smoke alarms">Báo cháy</option>
                    <option value="Minibar">Tủ lạnh mini</option>
                    <option value="Work Desk">Bàn làm việc</option>
                    <option value="Free Wi-Fi">Wi-Fi miễn phí</option>
                    <option value="Safety box">Két an toàn</option>
                    <option value="Rain Shower">Vòi sen mưa</option>
                    <option value="Slippers">Dép đi trong nhà</option>
                    <option value="Hair dryer">Máy sấy tóc</option>
                    <option value="Wake-up service">Dịch vụ báo thức</option>
                    <option value="Laundry & Dry Cleaning">Giặt ủi</option>
                    <option value="Electronic door lock">Khóa cửa điện tử</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="button" class="btn btn-success add-facility me-2"><i class="lni lni-circle-plus"></i></button>
                <button type="button" class="btn btn-danger remove-facility"><i class="lni lni-circle-minus"></i></button>
            </div>
        </div>
    @endforelse
</div>
                     </div> 
                  </div>
                  <br>

				<div class="col-md-12">
					<div class="d-md-flex d-grid align-items-center gap-3">
						<button type="submit" class="btn btn-primary px-4">Lưu thay đổi</button>
					</div>
				</div>
			</form>
							</div>
						</div>

					</div>
                            </div>

                            <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <a class="card-title btn btn-primary float-right" onclick="addRoomNo()" id="addRoomNo">
                                            <i class="lni lni-plus">Thêm mới</i>
                                        </a>
                                        <div class="roomnoHide" id="roomnoHide">
                                            <form action="{{ route('hotel.store.room.number', $editData->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="room_type_id" value="{{ $editData->roomtype_id }}">

                                                <div class="row">
                                            <div class="col-md-4">
                                                <label for="input2" class="form-label">Số phòng</label>
                                                <input type="text" name="room_no" class="form-control" id="input2">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="input7" class="form-label">Trạng thái</label>
                                                <select name="status" id="input7" class="form-select">
                                                    <option selected="">Chọn trạng thái...</option>
                                                    <option value="Active">Hoạt động</option>
                                                    <option value="Inactive">Không hoạt động</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-success" style="margin-top:28px; ">Lưu</button>
                                            </div>

                                            </div>
                                            </form>
                                        </div>
                                        <table class="table mb-0 table-striped" id="roomview">
									<thead>
										<tr>
                                            <th scope="col">Số phòng</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Hành động</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach ($allroomNo as $item)
										<tr>
											<td>{{ $item->room_no }}</td>
											<td>{{ $item->status }}</td>
											<td>
                                                <a href="{{ route('hotel.edit.roomno', $item->id) }}" class="btn btn-warning px-3 radius-30">Sửa</a>
                                                <a href="{{ route('hotel.delete.roomno', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Xóa</a>
                                            </td>
										</tr>
                                        @endforeach
									</tbody>
								</table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
        </div>
    </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#image').change(function(e){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#showImage').attr('src', e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		})
	})
</script>

<script>
   $(document).ready(function(){
    $('#multiImg').on('change', function(){ //on file input change
       if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
       {
           var data = $(this)[0].files; //this file data
            
           $.each(data, function(index, file){ //loop though each file
               if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                   var fRead = new FileReader(); //new filereader
                   fRead.onload = (function(file){ //trigger function on successful read
                   return function(e) {
                       var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                   .height(80); //create image element 
                       $('#preview_img').append(img); //append image to output element
                   };
                   })(file);
                   fRead.readAsDataURL(file); //URL representing the file's data.
               }
           });
            
       }else{
           alert("Trình duyệt của bạn không hỗ trợ File API!"); //if File API is absent
       }
    });
   });
</script>

<div style="visibility: hidden">
   <div class="whole_extra_item_add" id="whole_extra_item_add">
      <div class="basic_facility_section_remove" id="basic_facility_section_remove">
         <div class="container mt-2">
            <div class="row">
               <div class="form-group col-md-6">
                  <label for="basic_facility_name">Tiện nghi phòng</label>
                  <select name="facility_name[]" id="basic_facility_name" class="form-control">
                        <option value="">Chọn tiện nghi</option>
 <option value="Complimentary Breakfast">Bữa sáng miễn phí</option>
 <option value="32/42 inch LED TV">TV</option>
 <option value="Smoke alarms" >Báo khói</option>
 <option value="Minibar"> Tủ lạnh nhỏ (Minibar)</option>
 <option value="Work Desk" >Bàn làm việc</option>
 <option value="Free Wi-Fi">Wi-Fi miễn phí</option>
 <option value="Safety box" >Két an toàn</option>
 <option value="Rain Shower" >Vòi sen mưa</option>
 <option value="Slippers" >Dép đi trong nhà</option>
 <option value="Hair dryer" >Máy sấy tóc</option>
 <option value="Wake-up service" >Dịch vụ báo thức</option>
 <option value="Laundry & Dry Cleaning" >Giặt ủi</option>
 <option value="Electronic door lock" >Khoá cửa điện tử</option> 
                  </select>
               </div>
               <div class="form-group col-md-6" style="padding-top: 20px">
                  <span class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></span>
                  <span class="btn btn-danger removeeventmore"><i class="lni lni-circle-minus"></i></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   $(document).ready(function(){
      var counter = 0;
      $(document).on("click",".addeventmore",function(){
            var whole_extra_item_add = $("#whole_extra_item_add").html();
            $(this).closest(".add_item").append(whole_extra_item_add);
            counter++;
      });
      $(document).on("click",".removeeventmore",function(event){
            $(this).closest("#basic_facility_section_remove").remove();
            counter -= 1
      });
   });
</script>

<script>
    $('#roomnoHide').hide();
    $('#roomview').show();

   function addRoomNo(){
        $('#roomnoHide').show();
        $('#roomview').hide();
        $('#addRoomNo').hide();
   }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateFacilityOptions() {
        let selectedValues = [];

        // Thu thập các lựa chọn đã chọn
        $('.facility-select').each(function () {
            const val = $(this).val();
            if (val) selectedValues.push(val);
        });

        // Hiển thị tất cả các option trước
        $('.facility-select').each(function () {
            $(this).find('option').show();
        });

        // Ẩn những cái đã được chọn trong các dropdown khác
        $('.facility-select').each(function () {
            const currentVal = $(this).val();
            $(this).find('option').each(function () {
                if (selectedValues.includes($(this).val()) && $(this).val() !== currentVal) {
                    $(this).hide();
                }
            });
        });
    }

    $(document).ready(function () {
        updateFacilityOptions();

        // Thêm dòng mới
        $(document).on('click', '.add-facility', function () {
            const row = $(this).closest('.basic_facility_row');
            const clone = row.clone();

            // Reset dropdown
            clone.find('select').val('');

            $('#facility_container').append(clone);
            updateFacilityOptions();
        });

        // Xoá dòng
        $(document).on('click', '.remove-facility', function () {
            if ($('.basic_facility_row').length > 1) {
                $(this).closest('.basic_facility_row').remove();
                updateFacilityOptions();
            }
        });

        // Khi thay đổi dropdown
        $(document).on('change', '.facility-select', function () {
            updateFacilityOptions();
        });
    });
</script>

@endsection
