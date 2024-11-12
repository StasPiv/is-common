<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class EventMessageModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    private string $id;

    public function __construct(
        private readonly ?string $name = null,
        private readonly ?string $uploadId = null,
        private readonly ?UploadModel $upload = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUploadId(): ?string
    {
        return $this->uploadId;
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uploadId' => $this->uploadId,
        ];
    }

    public function getDataForSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uploadId' => $this->uploadId,
            'upload' => $this->getUpload()?->getDataForSerialize(),
        ];
    }

    public static function getInstance(...$data): static
    {
        $id = $data['id'];
        unset($data['id']);

        if (isset($data['upload'])) {
            $upload = $data['upload'][0];

            if (isset($upload['_id'])) {
                $upload['id'] = (string) $upload['_id'];
                unset($upload['_id']);
            }

            $data['upload'] = UploadModel::getInstance(...$upload);
        }

        $eventMessageModel = parent::getInstance(...$data);

        $eventMessageModel->setId($id);

        return $eventMessageModel;
    }

    public function getUpload(): ?UploadModel
    {
        return $this->upload;
    }
}
