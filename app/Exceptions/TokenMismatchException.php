<?php

namespace App\Exceptions;

use Exception;

class TokenMismatchException extends Exception
{
    //
    public function report()
    {
        //
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|null
     */
    public function render($request)
    {
            return response()->json([
                'status' => 'error',
                'data' => 'Unauthorized',
              ]);
    }
}
