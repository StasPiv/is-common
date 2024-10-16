<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class ReportModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private string $id,
        private readonly string $uploadId,
        private readonly array $reportParams,
        private readonly string $reportParamsHash,
        private ?array $result = null,
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

    public function getDataForSave(): array
    {
        return [
            'id' => $this->id,
            'uploadId' => $this->uploadId,
            'reportParams' => $this->reportParams,
            'reportParamsHash' => $this->reportParamsHash,
            'result' => $this->result,
        ];
    }

    public function getDataForSerialize(): array
    {
        return $this->getDataForSave();
    }

    /**
     * @return string
     */
    public function getUploadId(): string
    {
        return $this->uploadId;
    }

    /**
     * @return array
     */
    public function getReportParams(): array
    {
        return $this->reportParams;
    }

    /**
     * @return string
     */
    public function getReportParamsHash(): string
    {
        return $this->reportParamsHash;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param array|null $result
     *
     * @return ReportModel
     */
    public function setResult(?array $result): static
    {
        $this->result = $result;

        return $this;
    }

    public static function getInstance(...$data): static
    {
        /** @var \MongoDB\Model\BSONDocument $reportParams */
        $reportParams = $data['reportParams'];

        if ($reportParams instanceof BSONDocument) {
            $data['reportParams'] = $reportParams->getArrayCopy();
        }

        /** @var \MongoDB\Model\BSONArray $result */
        $result = $data['result'];

        if ($result instanceof BSONArray) {
            $data['result'] = $result->getArrayCopy();
        }

        return parent::getInstance(...$data);
    }
}