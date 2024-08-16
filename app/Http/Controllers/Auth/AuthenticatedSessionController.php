<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Validator;
class AuthenticatedSessionController extends Controller
{
    public $baseClass;
    public function __construct( )
    {
        $this->baseClass = new BaseController();
    }
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();
        $request->session()->regenerate();
        return response()->noContent();
    }
    public function apiStore(Request $request)
    {
        $validated = Validator::make($request->all(),[
           'email' => 'required|email',
           'password' => 'required',
       ]);
        if($validated->fails()){
            return $this->baseClass->error([
                'message' => 'The given data was invalid.',
                'errors' => $validated->errors()
            ], 422);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
           return $this->baseClass->error([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->baseClass->success('login successfully!',[
            'access_token' => $token,
            'user_id' => $user->id,
        ],200);
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        return $this->baseClass->success('Logged out successfully!',null,200);
    }
}