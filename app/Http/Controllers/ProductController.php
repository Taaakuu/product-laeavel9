<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @var Product|null 产品模型
     */
    public ?Product $model = null;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function showCreateForm(Request $request): Factory|View|Application
    {
        return view('product.create');
    }


    public function create(Request $request):RedirectResponse
    {
        // 验证数据并创建商品
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
            ]);

        // 成功后重定向到产品列表页面
        return redirect()->route('product.index')->with('success', '商品创建成功');
    }

    /**
     * 显示所有产品
     *
     * @return Factory|View|Application
     */
    public function index(Request $request): \Illuminate\View\View
    {

        $products = Product::all();

        // 使用分页，每页显示10个商品
        $products = Product::paginate(10);

        return view('product.index', compact('products'));
    }


    /**
     * 显示产品详情
     *
     * @param $id
     * @return Factory|View|Application
     */

    public function show($id): Factory|View|Application
    {
        $product = Product::find($id);
        return view('product.show', ['product' => $product]);
    }

    /**
     * 删除商品
     *
     * @param $id
     * @return RedirectResponse
     */

    public function delete($id): RedirectResponse
    {
        product::destroy($id);
        return redirect()->route('product.index');
    }

    /**
     * 编辑商品
     *
     * @param $id
     * @return Factory|View|Application
     */
    public function edit($id): Factory|View|Application
    {
        $product =Product::find($id);
        return view('product.edit', ['product' => $product]);
    }

    /**
     * 更新商品
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // 验证请求数据
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',

        ]);

        // 绑定数据到 Product 模型
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');

        // 保存更新后的数据到数据库
        $product->save();

        return redirect()->route('product.index')->with('success', '商品更新成功');
    }

    /**
     * 搜索商品
     *
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function search(Request $request)
    {
        // 处理搜索请求，根据输入搜索产品
        // 然后返回搜索结果页面
        $query = $request->input('search');

        if ($query) {
            $product = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();

            return view('product.search', compact('product', 'query'));
        }
    }

    public function filter(Request $request)
    {
        $type = $request->input('type');

        // 获取所有分类和品牌
        $categories = Category::all();
        $brands = Brand::all();

        // 根据筛选类型决定显示的筛选内容
        if ($type === 'category') {
            $product = Product::with('category')->get();
            return view('product.filters', compact('product', 'categories', 'brands', 'type'));
        }

        if ($type === 'brand') {
            $product = Product::with('brand')->get();
            return view('product.filters', compact('product', 'categories', 'brands', 'type'));
        }

        if ($type === 'price') {
            $product = Product::all(); // Price筛选可能会涉及更复杂的逻辑
            return view('product.filters', compact('product', 'categories', 'brands', 'type'));
        }

        if ($type === 'name') {
            $product = Product::all(); // Name筛选也可能需要用户输入或进一步逻辑
            return view('product.filters', compact('product', 'categories', 'brands', 'type'));
        }

        // 如果没有匹配的类型，返回商品列表
        $product = Product::paginate(10);
        return view('product.index', compact('product'));
    }



}
