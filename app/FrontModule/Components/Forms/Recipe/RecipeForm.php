<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Recipe;

use App\Model\Recipe\RecipeRepository;
use App\Model\RecipeCategory\RecipeCategoryRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\Utils\ArrayHash;
use Nette\Utils\Image;

class RecipeForm extends Control
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * @var RecipeCategoryRepository
     */
    private $recipeCategoryRepository;

    public function __construct(
        RecipeRepository $recipeRepository,
        RecipeCategoryRepository $recipeCategoryRepository
    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->recipeCategoryRepository = $recipeCategoryRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Recipe')
            ->setRequired('The name is required');

        $form->addCheckbox('new_recipe', 'New Recipe');

        $form->addSelect('recipe_category_id', 'Category', $this->recipeCategoryRepository->findAllForSelectBox())
             ->setPrompt('--Choose category--')
             ->setRequired('The category is required');

        $form->addTextArea('note', 'Note');

        $form->addSelect('rating', 'Rating', [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
            ->setPrompt('--Choose stars--');

        $form->addUpload('image', 'Recipe Image')
            ->addRule($form::IMAGE, 'Image must be JPEG, PNG, GIF or WebP.');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->recipeRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The recipe is deleted', 'info');
            $this->getPresenter()->redirect('Recipe:default');
        }

        /** @var FileUpload $image */
        $image = $values->image;
        $imagePath = null;


        if ($image->isImage() && $image->isOk()) {
            $fileImage =  Image::fromFile($image->getTemporaryFile());
            $imagePath =  '/img/upload/' . $image->getUntrustedName();
            $filePath = WWW_DIR . $imagePath;
            $fileImage->save($filePath);
        }

        if ($values->id === '') {
            $this->recipeRepository->create([
                'name' => $values->name,
                'new_recipe' => $values->new_recipe,
                'recipe_category_id' => $values->recipe_category_id,
                'note' => $values->note !== '' ? $values->note : null,
                'rating' => $values->rating !== '' ? $values->rating : null,
                'image_path' => $imagePath,
            ]);
            $this->getPresenter()->flashMessage('The new recipe is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name,
                'new_recipe' => $values->new_recipe,
                'recipe_category_id' => $values->recipe_category_id,
                'note' => $values->note !== '' ? $values->note : null,
                'rating' => $values->rating !== '' ? $values->rating : null,
                'image_path' => $imagePath,
            ];

            $this->recipeRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The recipe is updated', 'info');
        }

        $this->getPresenter()->redirect('Recipe:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/recipeForm.latte');
        $template->render();
    }
}