<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use ArrayObject;
use MongoDB\Model\BSONArray;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class EventMessageModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    private string $id;

    public function __construct(
        private readonly ?string $name = null,
        private readonly array $uploadId = [],
        private readonly array $upload = [],
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

    public function getUploadId(): array
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
        $uploadSerialized = array_map(
            fn (UploadModel $upload): array => $upload->getDataForSerialize(),
            $this->getUpload()
        );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'uploadId' => $this->uploadId,
            'upload' => $uploadSerialized,
        ];
    }

    public static function getInstance(...$data): static
    {
        $id = $data['id'];
        unset($data['id']);

        if (isset($data['upload'])) {
            $uploads = [];

            foreach ($data['upload'] as $upload) {
                if (!isset($upload['_id'])) {
                    continue;
                }

                $upload['id'] = (string)$upload['_id'];
                unset($upload['_id']);
                $uploads[] = UploadModel::getInstance(...$upload);
            }

            $data['upload'] = $uploads;
        }

        if (isset($data['uploadId']) && $data['uploadId'] instanceof BSONArray) {
            $data['uploadId'] = $data['uploadId']->getArrayCopy();
        }

        $eventMessageModel = parent::getInstance(...$data);
        $eventMessageModel->setId($id);

        return $eventMessageModel;
    }

    public function getUpload(): array
    {
        return $this->upload;
    }
}
