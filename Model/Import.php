<?php

/**
 * Pramod
 *
 * @category Pramod
 * @package  Pramod_CustomerImport
 * @author   Pramod Gupta <pramodguptabt07@gmail.com>
 */

namespace Pramod\CustomerImport\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Pramod\CustomerImport\Model\Customer as CustomerModel;
use Magento\Framework\Serialize\Serializer\Json;

class Import
{
    /**
     * @var CustomerModel
     */
    private $customerModel;

    /**
     * @var csv
     */
    private $csv;

    /**
     * @param  Filesystem                  $filesystem
     * @param  \Magento\Framework\File\Csv $csv
     * @param  Customer                    $customerModel
     * @param  Filesystem\Driver\File      $fileDriver
     * @param  Json                        $jsonSerializer
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Filesystem $filesystem,
        \Magento\Framework\File\Csv $csv,
        CustomerModel $customerModel,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        Json $jsonSerializer
    ) {
        $this->filesystem = $filesystem;
        $this->csv = $csv;
        $this->customerModel = $customerModel;
        $this->fileDriver =  $fileDriver;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::PUB);
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * This is import CsvData data function
     *
     * @param  array $fileData
     * @param  array $output
     * @return true|void
     * @throws \Exception
     */
    public function importCsvData($fileData, $output)
    {
        try {
            $fileName = $this->getImportDir() . '/' . $fileData['file-name'];
            if (!$this->fileExistsOrnot($fileName)) {
                $output->writeln("<error>File Does Not Exists!!!</error>");
                return 0;
            }

            $csvData = $this->csv->getData($fileName);
            if (count($csvData) > 0) {
                foreach ($csvData as $row => $data) {
                    if ($row > 0) {
                        $this->customerModel->updateCsvCustomer($data);
                    }
                }
            }
            return true;
        } catch (LocalizedException $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
            return 0;
        }
    }

    /**
     * This is import Json Data function
     *
     * @param  array $fileData
     * @param  array $output
     * @return true|void
     */
    public function importJsonData($fileData, $output)
    {
        try {
            $fileName =  $this->getImportDir() . '/' . $fileData['file-name'];
            if (!$this->fileExistsOrnot($fileName)) {
                $output->writeln("<error>File Does Not Exists!!!</error>");
                return 0;
            }

            $data = $this->fileDriver->fileGetContents($fileName);
            $unserializeData = $this->jsonSerializer->unserialize($data);
            $i = 0;
            foreach ($unserializeData as $key => $value) {
                if ($i == 0) {
                    $i++;
                    continue;
                }
                $this->customerModel->updateJsonCustomer($value);
            }
            return true;
        } catch (LocalizedException $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
            return 0;
        }
    }

    /**
     * Returns a default import directory (media/import).
     *
     * @return string
     */
    private function getImportDir(): string
    {
        $dirConfig = DirectoryList::getDefaultConfig();
        $dirAddon = $dirConfig[DirectoryList::MEDIA][DirectoryList::PATH];
        return $dirAddon . DIRECTORY_SEPARATOR . $this->mediaDirectory->getRelativePath('import');
    }

    /**
     * This is check function file Exists Or not
     *
     * @param  array $file
     * @return bool
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function fileExistsOrnot($file)
    {
        return $this->fileDriver->isExists($file);
    }
}
