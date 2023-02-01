<?php

namespace App\Http\Controllers;

use App\Util\fixedAssestSupplierUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\sto_fxhdr;
use App\Exports\SuplierExport;
use Maatwebsite\Excel\Facades\Excel;


class SuplierDetailsController extends Controller
{
    
    /**
     *  retriew data for filter data and send object value using jquery
     *  Fixed Assest Supplier Details
     *  @return view to display filter page
     */
    function supplier()
    {
        $sto_RetrnItems = DB::table('sto_fxissues')->get();

        $fxHdrs = sto_fxhdr::orderby('fh_FxDesc')
            ->orderBy('fh_FxDesc')
            ->get();

        $deptName= DB::table('sto_dept')->select("*")
            ->orderBy('deptName')
            ->get();

        return view('pages.reports.fixedAssets.suplier.supplier')->with('div', $deptName)->with('sto_fxhdrs', $fxHdrs)->with('retrnitms', $sto_RetrnItems)->with('div', $deptName);
    }

    /**
     * Fixed Asset suplier details display side bar
     * @param Request $request the selected dropdown list data 
     * @return View view suplier details page
     */
    function supplierViewSildeBar(Request $request)
    {

        $fromDate = $request->FromDate;
        $toDate = $request->Todate;
        $maincategory = $request->MainCategory;
        $division = $request->division;

        $displaySidebar = false;
        if ($maincategory  == "-1") {
            $displaySidebar = true;
        }
        $results = DB::table('sto_fxhdrs')->select('*')->orderBy('fh_FxDesc')->get();
        return view('pages.reports.fixedAssets.suplier.suplierdetails')->with('results', $results)->with('displaySidebar', $displaySidebar)->with('division', $division)->with('maincategory', $maincategory)->with('fromDate', $fromDate)->with('toDate', $toDate);
    }
    /**
     * get the selected table data according to side bar and conditions
     * @param Request $request request the object
     * @param $fxItem is the value of fh_FxHdr column in sto_fxhdr2s table
     * @param $division is the variable that store the select box data
     * @param $maincategory is the variable that store select box data 
     * @param $fromDate is the variable that store from date value in date picker 
     * @param $toDate is the variable that store to date value in date picker 
     * @return view content page 
     */
    function supplierView($fxItem, $division, $maincategory, $fromDate, $toDate)


        {
          //  
            [$supplier, $categorydescription] =fixedAssestSupplierUtils::supplierview( $fxItem,$division,
                $maincategory,
                $fromDate,
                $toDate
            );

            [$divisionNam, $maincategoryName] =fixedAssestSupplierUtils::category($division,$maincategory);
            return response()->json([
                'html' => view(
                    'pages.reports.fixedAssets.suplier.content',
                    compact(
                        'fxItem',
                        'supplier',
                        'maincategoryName',
                        'maincategory',
                        'division',
                        'divisionNam',
                        'categorydescription',
                        'fromDate',
                        
                        'toDate',
                        
                    )
                )->render()
            ]);
    
        }
         /**
     * Export data to excel for given function
     * @param $division request the object.
     * @param $maincategory request the object.
     * @param $subcategory request the object.
     * @param $fromDate request the object.
     * @param $toDate request the object.
     * @param $hedercode is the variable that get the side bar data.
     * @return request parameters send into fixedAssentItemsExport.
     */
    public function exportToExcel($fxItem, $division, $maincategory, $fromDate, $toDate)
    {
        if( $fromDate == "All" ? : '-1')
       {
        $fromDate = '-1';
       }
       if($toDate == 'All' ? : '-1')
       {
        $toDate = '-1';
       }
      
        ob_end_clean();
        ob_start();
        return  Excel::download(new SuplierExport(
            $fxItem,
            $division,
            $maincategory,
            $fromDate,
            $toDate
        ), 'fixedAssets.xlsx');
    }
}

