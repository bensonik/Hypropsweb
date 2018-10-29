<div id="my_payslip">
<table class="table table-bordered table-hover table-striped" id="payslip_table">
    <thead>
    </thead>
    <tbody>
    <tr>
        @if(!empty($companyInfo))
        <td>
            <table>
                <tbody>
                <tr>
                    <td>{{$companyInfo->name}}</td>
                </tr>
                <tr>
                    <td>{{$companyInfo->address}}</td>
                </tr>
                <tr>
                    <td>{{$companyInfo->phone1}}&nbsp; {{$companyInfo->phone2}}</td>
                </tr>
                <tr>
                    <td>{{$companyInfo->email}}</td>
                </tr>
                </tbody>
            </table>
        </td>
            <?php $imgUrl = \App\Helpers\Utility::IMG_URL(); ?>
        <td><img class="pull-right" src="{{ asset('images/'.$companyInfo->logo)}}"> </td>
        @else
            <td>
                <table>
                    <tbody>
                    <tr>
                        <td>Company Name</td>
                    </tr>
                    <tr>
                        <td>Company Address</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                    </tr>
                    </tbody>
                </table>
            </td>

            <td><img class="pull-right" src="{{ asset('images/'.\App\Helpers\Utility::DEFAULT_LOGO) }}"></td>
        @endif
    </tr>
    </tbody>
</table>

<table class="table table-bordered table-hover table-striped" id="">
    <tbody>
    <tr>
        <td>Employee Name</td><td>{{Auth::user()->title}} {{Auth::user()->firstname}} {{Auth::user()->lastname}}</td>
    </tr>
    <tr>
        <td>Department</td><td>{{$edit->department->dept_name}}</td>
    </tr>
    <tr>
        <td>Position</td><td>{{$edit->position->position_name}}</td>
    </tr>
    <tr>
        <td>Salary Structure</td><td>{{$edit->salary->salary_name}}</td>
    </tr>

    </tbody>
</table>

<?php $payRoll = json_decode($edit->salary->component,true); ?>
<table class="table table-bordered table-hover table-striped" id="">
    <tbody>
    <tr>

      <td>
          @if($payRoll != '')
              Allowances/Earnings
              <table class="table table-bordered table-hover">
                  <thead>
                  <th>Component</th>
                  <th>Amount</th>
                  </thead>
                  <tbody>
                  @foreach($payRoll as $comp)
                      @if($comp['component_type'] == \App\Helpers\Utility::COMPONENT_TYPE[1])
                      <tr>
                          <td>{{$comp['component']}}</td>
                          <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($comp['amount'])}}</td>
                      </tr>
                      @endif
                  @endforeach
                        @if($edit->bonus_deduc_type == \App\Helpers\Utility::PAYROLL_BONUS)
                            <tr>
                                <td>{{$edit->bonus_deduc_desc}}</td>
                                <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->bonus_deduc)}}</td>
                            </tr>
                        @endif


                  </tbody>
              </table>
          @endif
      </td>

        <td>
            @if($payRoll != '')
                Deductions
                <table class="table table-bordered table-hover">
                    <thead>
                    <th>Component</th>
                    <th>Amount</th>
                    </thead>
                    <tbody>
                    @foreach($payRoll as $comp)
                        @if($comp['component_type'] == \App\Helpers\Utility::COMPONENT_TYPE[2])
                            <tr>
                                <td>{{$comp['component']}}</td>
                                <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($comp['amount'])}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @if($edit->bonus_deduc_type == \App\Helpers\Utility::PAYROLL_DEDUCTION)
                        <tr>
                            <td>{{$edit->bonus_deduc_desc}}</td>
                            <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->bonus_deduc)}}</td>
                        </tr>
                    @endif
                    {{--<tr>
                        <td>PAYE</td>
                        <td>{{$edit->currency->symbol}} {{number_format($taxAmount)}}</td>
                    </tr>--}}

                    </tbody>
                </table>
            @endif
        </td>
    </tr>
    </tbody>
</table>

<table class="table table-bordered table-hover">
    <tbody>
    <tr>
        <td>Gross Salary</td>
        <td style="font-size:15px;">{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->salary->gross_pay)}}</td>
    </tr>
    <tr>
        <td>Total Deductions</td>
        <td style="font-size:15px;">{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($totalDeduction)}}</td>
    </tr>
    <tr>
        <td>Net Salary</td>
        <td style="font-size:15px;">{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->total_amount)}}</td>
    </tr>
    </tbody>
</table>

</div>


