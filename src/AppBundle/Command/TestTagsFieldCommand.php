<?php

namespace AppBundle\Command;

use Netgen\TagsBundle\API\Repository\Values\Tags\Tag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\Exceptions\UnauthorizedException;
use Symfony\Component\Console\Question\Question;


class TestTagsFieldCommand extends ContainerAwareCommand
{
    /**
     * This method override configures on input argument for the content id.
     */
    protected function configure()
    {
        $this->setName('websc:fieldtypes:test');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface  $input  An InputInterface instance
     * @param \Symfony\Component\Console\Output\OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract method is not implemented
     * @see    setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \eZ\Publish\API\Repository\Repository $repository */
        $repository = $this->getContainer()->get('ezpublish.api.repository');
        $fieldHelper = $this->getContainer()->get( 'ezpublish.field_helper' );
        $translationHelper = $this->getContainer()->get( 'ezpublish.translation_helper' );
        $contentService = $repository->getContentService();
        $fieldTypeService = $repository->getFieldTypeService();

        $helper = $this->getHelper('question');
        $question = new Question('');

        $contentId = 87;
        $output->writeln( "Test: display tags field for content with id " . $contentId );
        $helper->ask($input, $output, $question);

        // fetch content and display tags
        try
        {
            $content = $contentService->loadContent($contentId);
            if ( isset( $content->fields['tags'] ) && !$fieldHelper->isFieldEmpty( $content, 'tags' ) )
            {
                $field = $translationHelper->getTranslatedField( $content, 'tags' );
                $fieldValue = $field->value;
                $fieldDefinition = $fieldHelper->getFieldDefinition($content->contentInfo, $field->fieldDefIdentifier);
                $fieldType = $fieldTypeService->getFieldType($fieldDefinition->fieldTypeIdentifier);

                // We use the Field's toHash() method to get readable, serializable content out of the Field
                $tags = $fieldType->toHash($fieldValue);

                $output->writeln('Field hash:');
                $helper->ask($input, $output, $question);
                dump($tags);
                $helper->ask($input, $output, $question);

                $output->writeln('Field value:');
                $helper->ask($input, $output, $question);
                dump($fieldValue);
                $helper->ask($input, $output, $question);

                $output->writeln('Keywords from tag objects:');
                $helper->ask($input, $output, $question);
                /** @var Tag $tagObject */
                foreach($fieldValue->tags as $tagObject)
                {
                    $output->writeln(" - " . $tagObject->keyword . "\n");
                }
                $helper->ask($input, $output, $question);
            }
        }
        catch ( NotFoundException $e )
        {
            // if the id is not found
            $output->writeln("No content with id $contentId");
        }
        catch ( UnauthorizedException $e )
        {
            // not allowed to read this content
            $output->writeln("Anonymous users are not allowed to read content with id $contentId");
        }


        // update current data
        $userService = $repository->getUserService();
        $user = $userService->loadUser(14);

        $repository->setCurrentUser($user);

        try {
            $tagService = $this->getContainer()->get('ezpublish.api.service.tags');
            $tag = $tagService->loadTagsByKeyword('Sports', 'eng-GB');

            $output->writeln("Load tag with keyword 'Sports': ");
            $helper->ask($input, $output, $question);
            dump($tag);
            $helper->ask($input, $output, $question);

            $output->writeln("Update tag content: ");
            $contentInfo = $contentService->loadContentInfo($contentId);
            $contentDraft = $contentService->createContentDraft($contentInfo);

            $contentUpdateStruct = $contentService->newContentUpdateStruct();

            $contentUpdateStruct->setField('tags', $tag);

            $contentDraft = $contentService->updateContent($contentDraft->versionInfo, $contentUpdateStruct);
            $content = $contentService->publishVersion($contentDraft->versionInfo);

            $output->writeln("Print new field value: ");
            $helper->ask($input, $output, $question);
            $field = $translationHelper->getTranslatedField( $content, 'tags' );
            $fieldValue = $field->value;
            foreach($fieldValue->tags as $tagObject)
            {
                $output->writeln(" - " . $tagObject->keyword . "\n");
            }
        }
        catch (\eZ\Publish\API\Repository\Exceptions\NotFoundException $e)
        {
            // react on content not found
            $output->writeln($e->getMessage());
        }
        catch (\eZ\Publish\API\Repository\Exceptions\ContentFieldValidationException $e)
        {
            // react on a field is not valid
            $output->writeln($e->getMessage());
        }
        catch (\eZ\Publish\API\Repository\Exceptions\ContentValidationException $e)
        {
            // react on a required field is missing or empty
            $output->writeln($e->getMessage());
        }
    }
}