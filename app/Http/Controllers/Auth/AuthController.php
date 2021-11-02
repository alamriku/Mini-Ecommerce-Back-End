<?php


namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    private $token;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','store']]);
    }

    /**
     * Get a JWT via given credentials.
     * @param Request $request
     *
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:2',
        ]);
        if (! $token = auth()->setTTL(240)->attempt($credentials)) {
            $this->errorUnauthorized();
            return ($this->respondWithError('Wrong Email or Password.','emailPass410'));
        }
        $this->token = $token;
        return $this->respondWithArray($this->getAuthenticatedData());
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:2|confirmed',
        ]);
        $data = json_decode($request->getContent(), true);
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
        $credentials = request(['email', 'password']);

        if (! $token = auth()->setTTL(420)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $this->token = $token;
        return $this->respondWithArray($this->getAuthenticatedData());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array
     */
    protected function getAuthenticatedData() : array
    {
        return [
            'access_token' => $this->token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'isAdmin' => (boolean) auth()->user()->is_admin,
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
