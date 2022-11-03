<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Resource extends JsonResource
{
    public const FULL_FORM = 'full';
    public const SHORT_FORM = 'short';

//    private ?string $display_form;
//
//    public function __construct($resource, ?string $display_form = null)
//    {
//        parent::__construct($resource);
//
//        $this->display_form = $display_form ?? null;
//    }

//    /**
//     * Transform the resource into an array.
//     *
//     * @param Request $request
//     * @return array
//     * @throws HttpClientException|Exception
//     */
//    public function toArray($request): array
//    {
//        return $this->toFullForm();
//        /** @var Request $request */
//        $request = request();
//
//        if ($this->display_form === null) {
//            $this->display_form = $request->get('display_form', self::FULL_FORM);
//        }
//
//        return match ($this->display_form) {
//            self::FULL_FORM => $this->toFullForm(),
//            self::SHORT_FORM => $this->toShortForm(),
//            default => throw new HttpClientException(
//                'Не обрабатываемая форма отображения ресурса ' . get_class($this) . ' : \'' . $this->display_form . '\''
//            ),
//        };
//    }

//    abstract public function toFullForm(): array;
//
//    /**
//     * @return array
//     * @throws Exception
//     */
//    public function toShortForm(): array
//    {
//        throw new Exception('method ' . get_class($this) . '::' . 'toShortForm not implemented');
//    }

}
