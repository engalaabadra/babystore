<?php

namespace Modules\Chat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Access\AuthorizationException;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rules;

/**
 * Class StoreChatRequest.
 */
class StoreChatRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * StoreBannerRequest constructor.
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the  is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authorizeRes= $this->baseRepo->authorizeSuperAndAdmin();
        if($authorizeRes==true){
                return true;
            
        }else{
            return $this->failedAuthorization();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['required'],
            'client_id' => ['numeric','exists:users,id'],
            'user_id' => ['numeric','exists:users,id'],
            'chat_room_id' => ['numeric','exists:chat_rooms,id'],
           
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
        /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException(__('Only the superadministrator and admins can make this action'));
    }
}
