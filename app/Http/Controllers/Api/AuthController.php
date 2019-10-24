<?php

namespace App\Http\Controllers\Api;

use App\Constracts\Code;
use App\Models\OauthClient;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    /**
     * 获取身份令牌
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Project\Exceptions\ApiException
     */
    public function token(Request $request)
    {
        // 表单验证
        $validator = \Validator::make($request->all(), [
            'phone' => 'required|min:11|max:11',
            'password' => 'required',
        ], [
            'phone.required' => $this->ruleMsg(Code::E_AUTH_NAME_REQUIRED),
            'phone.min' => $this->ruleMsg(Code::E_AUTH_PHONE_LENGTH_ERROR),
            'phone.max' => $this->ruleMsg(Code::E_AUTH_PHONE_LENGTH_ERROR),
            'password.required' => $this->ruleMsg(Code::E_AUTH_PASSWORD_REQUIRED),
        ]);

        $this->validatorErrors($validator);

        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
        ];

        if (!\Auth::attempt($credentials)) {
            $this->thrown(Code::E_AUTH_LOGIN_FAILED);
        }

        return $this->response('登录成功', $this->requestAccessToken());
    }

    /**
     * 刷新令牌
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Project\Exceptions\ApiException
     */
    public function refreshToken(Request $request)
    {
        $refreshToken = $request->refresh_token;

        if (is_null($refreshToken)) {
            $this->thrown(Code::E_AUTH_REFRESH_TOKEN_REQUIRED);
        }

        $oauthClient = OauthClient::byName(config('auth.oauth_client_name'))->firstOrFail();

        $tokenParams = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $oauthClient->id,
            'client_secret' => $oauthClient->secret,
            'scope' => $request->input('scope', '')
        ];

        $issueTokenUrl = 'oauth/token';
        $request->request->add($tokenParams);
        $proxy = Request::create($issueTokenUrl, 'POST', $tokenParams);

        $response = \Route::dispatch($proxy);
        $oauth = json_decode($response->content());

        if (is_null($oauth) || isset($oauth->error)) {
            $this->thrown(Code::E_AUTH_TOKEN_REFRESH_FAILED);
        }

        return $this->response('更新成功', $oauth);
    }

    /**
     * 销毁token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeToken(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->response('注销成功');
    }

    /**
     * 请求access token
     *
     * @return mixed
     * @throws \Project\Exceptions\ApiException
     */
    protected function requestAccessToken()
    {
        $oauthClient = OauthClient::byName(config('auth.oauth_client_name'))->firstOrFail();

        $request = \request();

        $tokenParams = [
            'grant_type' => 'password',
            'username' => $request->phone,
            'password' => $request->password,
            'client_id' => $oauthClient->id,
            'client_secret' => $oauthClient->secret,
            'scope' => $request->input('scope', '*')
        ];

        $issueTokenUrl = 'oauth/token';
        $request->request->add($tokenParams);
        $proxy = Request::create($issueTokenUrl, 'POST', $tokenParams);

        $response = \Route::dispatch($proxy);
        $oauth = json_decode($response->content());

        if (is_null($oauth) || isset($oauth->error)) {
            $this->thrown(Code::E_AUTH_TOKEN_CREATE_FAILED);
        }

        return $oauth;
    }
}
