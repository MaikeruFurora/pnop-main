<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enrollStudentModal">
    Launch static backdrop modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="enrollStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="enrollStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Enroll Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label >Fullname</label>
                    <input type="text" class="form-control" name="fullname" readonly>
                  </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label >Grade level</label>
                       <select name="grade_level"  class="custom-select">
                          <option value="7">Grade 7</option>
                          <option value="8">Grade 8</option>
                          <option value="9">Grade 9</option>
                          <option value="10">Grade 10</option>
                       </select>
                      </div>
                  <div class="form-group col-md-6">
                    <label>Learning Reference No.</label>
                    <input type="text" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                    <label>Curriculum</label>
                    <select name="curriculum" class="custom-select">
                        <option value="STEM">STEM - Science Technology Engineering and Mathematics</option>
                        <option value="BEC">BEC - Basic Education Curriculum</option>
                        <option value="SPA">SPA - Special Program Art</option>
                        <option value="SPJ">SPJ - Special Program Journalism</option>
                    </select>
                </div>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Action Taken
                      <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Enrollment Status
                      <span class="badge badge-primary badge-pill">2</span>
                    </li>
                  </ul>
                  <div class="form-group">
                    <label>Assign Section</label>
                    <select name="curriculum" class="custom-select">
                       
                    </select>
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Enroll</button>
        </div>
      </div>
    </div>
  </div>